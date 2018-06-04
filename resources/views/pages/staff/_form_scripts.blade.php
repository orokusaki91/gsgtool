{{-- Disable input on change account type --}}
<script>
    $(document).ready(function() {
        if($('#acc_type').val() == '1'){
            $("#number_bank").prop('disabled', false);
            $("#number_post").prop('disabled', true);
        }else if($('#acc_type').val() == '2'){
            $("#number_post").prop('disabled', false);
            $("#number_bank").prop('disabled', true);
        }
        $('#acc_type').on('change', function () {
            if($('#acc_type').val() == '1'){
                $("#number_bank").prop('disabled', false);
                $("#number_post").prop('disabled', true);
            }else if($('#acc_type').val() == '2'){
                $("#number_post").prop('disabled', false);
                $("#number_bank").prop('disabled', true);
            }
        })
    });
</script>

{{-- Disable input if person is not married --}}
<script>
    $(document).ready(function() {
        if($('#marital_status').val() == '1'){
            $("#wedding_date").prop('disabled', false);
        }else{
            $("#wedding_date").prop('disabled', true);
        }
        $('#marital_status').on('change', function () {
            if($('#marital_status').val() == '1'){
                $("#wedding_date").prop('disabled', false);
            }else{
                $("#wedding_date").prop('disabled', true);
            }
        })
    });
</script>

{{-- Disable input if the person is from Switzerland --}}
<script>
    $(document).ready(function() {
        if($('#nationality').val() == 'CH'){
            $("#work_permit").prop('disabled', true);
            $("#work_permit_date").prop('disabled', true);
        }else{
            $("#work_permit").prop('disabled', false);
            $("#work_permit_date").prop('disabled', false);
        }
        $('#nationality').on('change', function () {
            if($('#nationality').val() == 'CH'){
                $("#work_permit").prop('disabled', true);
                $("#work_permit_date").prop('disabled', true);
            }else{
                $("#work_permit").prop('disabled', false);
                $("#work_permit_date").prop('disabled', false);
            }
        })
    });
</script>