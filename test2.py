import socket
import time
import csv
import os
import re
from datetime import datetime

def receive_from_mindray(ip='10.0.0.2', port=5100, buffer_size=4096):
    try:
        with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
            sock.settimeout(10)
            print(f"Connecting to Mindray at {ip}:{port}...")
            sock.connect((ip, port))
            print("Connected. Listening for HL7 data...\n")
            
            full_data = ""
            
            while True:
                try:
                    data = sock.recv(buffer_size)
                    if not data:
                        print("No data received. Waiting...")
                        time.sleep(1)
                        continue
                    
                    decoded_data = data.decode('utf-8', errors='ignore')
                    full_data += decoded_data
                    print("Received chunk:")
                    print(repr(decoded_data))  # Use repr to see control characters
                    
                    # Check for HL7 message termination characters
                    if '\x1c' in decoded_data or '\x0d' in decoded_data:
                        print("Found message terminator")
                        break
                        
                except socket.timeout:
                    print("No data in 10 seconds. Retrying...")
                    continue
                except UnicodeDecodeError as e:
                    print(f"Decode error: {e}")
                    continue
                    
            return full_data
            
    except Exception as e:
        print(f"Connection error: {e}")
        return None

def parse_hl7(hl7_message):
    results = {}
    if not hl7_message:
        return results
    
    print(f"\nFull HL7 message length: {len(hl7_message)} characters")
    print("Full HL7 message:")
    print(repr(hl7_message))
    
    # Split by common HL7 delimiters
    # Try different splitting methods
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
    
    print(f"\nFound {len(lines)} lines/segments:")
    for i, line in enumerate(lines):
        print(f"Line {i}: {repr(line)}")
    
    for line in lines:
        line = line.strip()
        if not line:
            continue
            
        # Split by pipe character
        fields = line.split('|')
        print(f"\nProcessing line: {line}")
        print(f"Fields: {fields}")
        
        # Process OBX segments with numeric values
        if len(fields) > 6 and fields[0] == 'OBX':
            try:
                segment_type = fields[0]
                set_id = fields[1]
                value_type = fields[2]
                observation_id = fields[3]
                observation_sub_id = fields[4] if len(fields) > 4 else ""
                observation_value = fields[5] if len(fields) > 5 else ""
                units = fields[6] if len(fields) > 6 else ""
                
                print(f"  OBX Analysis:")
                print(f"    Set ID: {set_id}")
                print(f"    Value Type: {value_type}")
                print(f"    Observation ID: {observation_id}")
                print(f"    Value: {observation_value}")
                print(f"    Units: {units}")
                
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
                    
                    print(f"    -> Added: {test_name} = {observation_value} {units}")
                
                # Also capture text values for reference
                elif value_type in ['ST', 'TX'] and observation_value:
                    test_name = observation_id
                    if '^' in observation_id:
                        parts = observation_id.split('^')
                        test_name = parts[1] if len(parts) > 1 else parts[0]
                    
                    test_name = test_name.strip()
                    results[f"{test_name}_text"] = observation_value
                    
            except (IndexError, ValueError) as e:
                print(f"    Error parsing line: {e}")
                continue
    
    return results

def save_to_csv(data_dict, filename="mindray_results.csv"):
    if not data_dict:
        print("No data to save")
        return
    
    # Add timestamp
    data_dict['timestamp'] = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    
    file_exists = os.path.isfile(filename)
    
    with open(filename, mode='a', newline='', encoding='utf-8') as csv_file:
        writer = csv.DictWriter(csv_file, fieldnames=data_dict.keys())
        
        if not file_exists:
            writer.writeheader()
        
        writer.writerow(data_dict)
    
    print(f"Results saved to {filename}")

def main():
    print("Starting Mindray HL7 data collection...")
    
    hl7_data = receive_from_mindray()
    
    # Save raw HL7 message with timestamp
    timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
    raw_filename = f"raw_hl7_log_{timestamp}.txt"
    
    with open(raw_filename, "w", encoding="utf-8") as f:
        f.write(hl7_data or "No data received")
    
    print(f"Raw HL7 data saved to {raw_filename}")
    
    if hl7_data:
        parsed_results = parse_hl7(hl7_data)
        
        print("\n" + "="*50)
        print("✅ PARSED RESULTS:")
        print("="*50)
        
        if parsed_results:
            for key, value in parsed_results.items():
                print(f"{key}: {value}")
            
            save_to_csv(parsed_results)
            print(f"\n💾 Results saved to CSV with {len(parsed_results)} fields")
        else:
            print("⚠️ No results found in HL7 message.")
            print("Check the raw HL7 log file for debugging.")
    else:
        print("❌ No HL7 data received")
    
    input("\n🔚 Press Enter to exit...")

if __name__ == "__main__":
    main()
    input("\n🔚 Press Enter to exit...")
