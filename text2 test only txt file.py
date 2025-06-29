import socket
import time
import os
import re
from datetime import datetime
import threading

def setup_output_directory():
    """Setup output directory with fallback logic"""
    # Try D drive first, then C drive, then current directory
    output_dir = None
    
    # Try D drive first
    try:
        d_dir = "D:/Mindray Result"
        os.makedirs(d_dir, exist_ok=True)
        output_dir = d_dir
        print(f"✅ Using D: drive directory: {output_dir}")
    except Exception as e:
        print(f"❌ D: drive not available: {e}")
        
        # Try C drive as fallback
        try:
            c_dir = "C:/Mindray Result"
            os.makedirs(c_dir, exist_ok=True)
            output_dir = c_dir
            print(f"✅ Using C: drive directory: {output_dir}")
        except Exception as e:
            print(f"❌ C: drive directory creation failed: {e}")
            # Final fallback to current directory
            output_dir = "."
            print(f"✅ Using current directory: {output_dir}")
    
    return output_dir

def extract_patient_info(hl7_message):
    """Extract patient ID and name from HL7 PID segment"""
    pid_info = {"id": "Unknown", "name": "Patient"}
    
    if not hl7_message:
        return pid_info
    
    # Split by common HL7 delimiters to find lines
    lines = []
    if '\r' in hl7_message:
        lines = hl7_message.split('\r')
    elif '\n' in hl7_message:
        lines = hl7_message.split('\n')
    else:
        lines = [hl7_message]
    
    for line in lines:
        line = line.strip()
        if line.startswith('PID|'):
            fields = line.split('|')
            try:
                # PID segment structure: PID|Set ID|Patient ID|Patient ID List|Alt Patient ID|Patient Name|...
                if len(fields) > 3 and fields[3]:  # Patient ID is usually in field 3
                    pid_info["id"] = fields[3].strip()
                
                if len(fields) > 5 and fields[5]:  # Patient Name is usually in field 5
                    # HL7 name format: LastName^FirstName^MiddleName
                    name_parts = fields[5].split('^')
                    if len(name_parts) >= 2:
                        pid_info["name"] = f"{name_parts[1].strip()} {name_parts[0].strip()}"  # FirstName LastName
                    else:
                        pid_info["name"] = fields[5].strip()
                
            except (IndexError, AttributeError):
                pass
            break
    
    return pid_info

def parse_hl7(hl7_message):
    """Parse HL7 message and extract test results"""
    results = {}
    if not hl7_message:
        return results
    
    print(f"\n📊 Processing HL7 message ({len(hl7_message)} characters)")
    
    # Split by common HL7 delimiters
    lines = []
    
    # Method 1: Split by \r (carriage return)
    if '\r' in hl7_message:
        lines = hl7_message.split('\r')
    # Method 2: Split by \n (line feed)  
    elif '\n' in hl7_message:
        lines = hl7_message.split('\n')
    # Method 3: Split by OBX (if segments are concatenated)
    else:
        # Find all OBX segments using regex
        obx_pattern = r'OBX\|[^O]*(?=OBX\||$)'
        lines = re.findall(obx_pattern, hl7_message)
    
    print(f"🔍 Found {len(lines)} segments to process")
    
    for line in lines:
        line = line.strip()
        if not line:
            continue
            
        # Split by pipe character
        fields = line.split('|')
        
        # Process OBX segments with numeric values
        if len(fields) > 6 and fields[0] == 'OBX':
            try:
                value_type = fields[2]
                observation_id = fields[3]
                observation_value = fields[5] if len(fields) > 5 else ""
                units = fields[6] if len(fields) > 6 else ""
                
                # Process numeric values (NM type)
                if value_type == 'NM' and observation_value:
                    # Extract test name from observation_id
                    test_name = observation_id
                    if '^' in observation_id:
                        parts = observation_id.split('^')
                        test_name = parts[1] if len(parts) > 1 else parts[0]
                    
                    # Clean up test name
                    test_name = test_name.strip()
                    
                    results[test_name] = observation_value
                    if units:
                        results[f"{test_name}_unit"] = units
                
                # Also capture text values for reference
                elif value_type in ['ST', 'TX'] and observation_value:
                    test_name = observation_id
                    if '^' in observation_id:
                        parts = observation_id.split('^')
                        test_name = parts[1] if len(parts) > 1 else parts[0]
                    
                    test_name = test_name.strip()
                    results[f"{test_name}_text"] = observation_value
                    
            except (IndexError, ValueError) as e:
                continue
    
    return results

def save_parsed_results_to_txt(parsed_results, patient_info, output_dir):
    """Save parsed results to a text file"""
    if not parsed_results:
        print("⚠️ No parsed results to save to TXT file")
        return None
    
    # Create filename with patient ID, name, and date
    current_date = datetime.now().strftime('%Y-%m-%d_%H-%M-%S')
    patient_id = patient_info.get("id", "Unknown").replace(" ", "_")
    patient_name = patient_info.get("name", "Patient").replace(" ", "_")
    
    # Clean filename characters that are not allowed in Windows
    patient_id = re.sub(r'[<>:"/\\|?*]', '_', patient_id)
    patient_name = re.sub(r'[<>:"/\\|?*]', '_', patient_name)
    
    filename = f"{patient_id}_{patient_name}_{current_date}.txt"
    filepath = os.path.join(output_dir, filename)
    
    try:
        with open(filepath, 'w', encoding='utf-8') as txt_file:
            # Write header
            txt_file.write("="*50 + "\n")
            txt_file.write("✅ MINDRAY PARSED RESULTS\n")
            txt_file.write("="*50 + "\n")
            txt_file.write(f"Patient ID: {patient_info.get('id', 'Unknown')}\n")
            txt_file.write(f"Patient Name: {patient_info.get('name', 'Patient')}\n")
            txt_file.write(f"Date & Time: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n")
            txt_file.write("="*50 + "\n\n")
            
            # Write all parsed results
            for key, value in parsed_results.items():
                if key != 'timestamp':  # Skip timestamp as we already have date/time in header
                    txt_file.write(f"{key}: {value}\n")
            
            txt_file.write("\n" + "="*50 + "\n")
            txt_file.write("End of Results\n")
            txt_file.write("="*50 + "\n")
        
        print(f"📄 Results saved to: {filepath}")
        return filepath
        
    except Exception as e:
        print(f"❌ Error saving TXT file: {e}")
        return None

def process_hl7_data(hl7_data, output_dir, result_counter):
    """Process a single HL7 message and save results"""
    if not hl7_data:
        return
    
    print(f"\n{'='*60}")
    print(f"🔬 PROCESSING RESULT #{result_counter}")
    print(f"{'='*60}")
    
    # Extract patient information
    patient_info = extract_patient_info(hl7_data)
    print(f"👤 Patient Info: ID={patient_info['id']}, Name={patient_info['name']}")
    
    # Parse HL7 data
    parsed_results = parse_hl7(hl7_data)
    
    if parsed_results:
        print(f"\n✅ PARSED RESULTS (Result #{result_counter}):")
        print("="*50)
        
        # Display results on console
        for key, value in parsed_results.items():
            print(f"{key}: {value}")
        
        # Save parsed results to TXT file (ONLY FILE CREATED)
        txt_filepath = save_parsed_results_to_txt(parsed_results, patient_info, output_dir)
        
        print(f"\n🎉 Result #{result_counter} processing completed!")
        
    else:
        print("⚠️ No results found in HL7 message.")

def listen_for_mindray_data(ip='10.0.0.2', port=5100, buffer_size=4096):
    """Continuously listen for Mindray data and process each result"""
    
    # Setup output directory once at startup
    output_dir = setup_output_directory()
    result_counter = 0
    
    print(f"\n🚀 Starting Mindray HL7 Continuous Data Collection...")
    print(f"📡 Listening on {ip}:{port}")
    print(f"📁 Output Directory: {output_dir}")
    print(f"📄 Only creating parsed results files (.txt)")
    print(f"⏹️  Press Ctrl+C to stop\n")
    
    while True:
        try:
            with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
                sock.settimeout(30)  # 30 second timeout
                print(f"🔄 Attempting to connect to Mindray at {ip}:{port}...")
                
                try:
                    sock.connect((ip, port))
                    print(f"✅ Connected! Waiting for HL7 data...\n")
                    
                    while True:
                        try:
                            full_data = ""
                            
                            # Receive data until we get a complete message
                            while True:
                                data = sock.recv(buffer_size)
                                if not data:
                                    break
                                
                                decoded_data = data.decode('utf-8', errors='ignore')
                                full_data += decoded_data
                                
                                # Check for HL7 message termination characters
                                if '\x1c' in decoded_data or '\x0d' in decoded_data:
                                    break
                            
                            if full_data.strip():
                                result_counter += 1
                                
                                # Process the received data
                                process_hl7_data(full_data, output_dir, result_counter)
                                
                                print(f"\n⏳ Waiting for next result... (Result #{result_counter} completed)")
                                print("-" * 60)
                            
                        except socket.timeout:
                            print("⏱️  No data received in 30 seconds, still listening...")
                            continue
                        except UnicodeDecodeError as e:
                            print(f"❌ Decode error: {e}")
                            continue
                        except Exception as e:
                            print(f"❌ Error processing data: {e}")
                            break
                
                except ConnectionRefusedError:
                    print(f"❌ Connection refused. Is Mindray device running and accessible at {ip}:{port}?")
                except socket.timeout:
                    print("⏱️  Connection timeout. Retrying...")
                except Exception as e:
                    print(f"❌ Connection error: {e}")
                
        except KeyboardInterrupt:
            print(f"\n\n🛑 Stopping data collection...")
            print(f"📊 Total results processed: {result_counter}")
            break
        except Exception as e:
            print(f"❌ Unexpected error: {e}")
        
        # Wait before retrying connection
        print("⏳ Waiting 10 seconds before reconnecting...")
        time.sleep(10)

def main():
    """Main function to start the continuous data collection"""
    try:
        listen_for_mindray_data()
    except KeyboardInterrupt:
        print("\n👋 Goodbye!")
    except Exception as e:
        print(f"❌ Fatal error: {e}")
    
    input("\n🔚 Press Enter to exit...")

if __name__ == "__main__":
    main()