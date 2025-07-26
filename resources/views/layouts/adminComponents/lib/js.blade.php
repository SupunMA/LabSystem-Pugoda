














<!-- jQuery -->
{{-- <script src={{ URL::asset('adminPages/v3/plugins/jquery/jquery.min.js'); }}></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Bootstrap 4 -->
{{-- <script src={{ URL::asset('adminPages/v3/plugins/bootstrap/js/bootstrap.bundle.min.js'); }}></script> --}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

<!-- AdminLTE App -->

{{-- <script src={{ URL::asset('dist/js/adminlte.min.js'); }}></script> --}}
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

<!-- logout Modal js -->
<script>
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

</script>

<!-- DataTables  & Plugins -->

<script src={{ URL::asset('adminPages/v3/plugins/datatables/jquery.dataTables.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/jszip/jszip.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/pdfmake/pdfmake.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/pdfmake/vfs_fonts.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/datatables-buttons/js/buttons.html5.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/datatables-buttons/js/buttons.print.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/datatables-buttons/js/buttons.colVis.min.js'); }}></script>


<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ URL::asset('dist/js/demo.js'); }}"></script> --}}

<!-- Page specific script -->
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "pdf", "print", "colvis"] //"csv","copy"
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

</script>

<!-- dropdown menu and other form Js files -->
<!-- Select2 -->
<!-- Select2 -->
<script src={{ URL::asset('adminPages/v3/plugins/select2/js/select2.full.min.js'); }}></script>
<!-- Bootstrap4 Duallistbox -->
<script src={{ URL::asset('adminPages/v3/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'); }}></script>
<!-- InputMask -->
<script src={{ URL::asset('adminPages/v3/plugins/moment/moment.min.js'); }}></script>
<script src={{ URL::asset('adminPages/v3/plugins/inputmask/jquery.inputmask.min.js'); }}></script>
<!-- date-range-picker -->
<script src={{ URL::asset('adminPages/v3/plugins/daterangepicker/daterangepicker.js'); }}></script>
<!-- bootstrap color picker -->
<script src={{ URL::asset('adminPages/v3/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'); }}></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src={{ URL::asset('adminPages/v3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); }}>
</script>
<!-- Bootstrap Switch -->
<script src={{ URL::asset('adminPages/v3/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); }}></script>
<!-- BS-Stepper -->
<script src={{ URL::asset('adminPages/v3/plugins/bs-stepper/js/bs-stepper.min.js'); }}></script>
<!-- dropzonejs -->
<script src={{ URL::asset('adminPages/v3/plugins/dropzone/min/dropzone.min.js'); }}></script>

<!-- Page specific script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function (event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

    })




</script>



{{-- Tost Messages --}}
<!-- SweetAlert2 -->

<script src={{ URL::asset('adminPages/v3/plugins/sweetalert2/sweetalert2.min.js'); }}></script>
<!-- Toastr -->
<script src={{ URL::asset('adminPages/v3/plugins/toastr/toastr.min.js'); }}></script>




@stack('specificJs')
