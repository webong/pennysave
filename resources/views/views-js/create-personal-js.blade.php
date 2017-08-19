<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/selectize.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $("select").selectize();

        $('#start_date').change(function() {
            var $targetAmount = $('#target_amount').val();
            var $instalmentAmount = $('#instalment_amount').val();
            var $intervals = $('#recurrence').val();
            var $startDate = $(this).val();
            var $result = calculate_target_date($startDate, $targetAmount, $instalmentAmount, $intervals);
            if ($result) {
                $conclude = generate_analysis_html($result, $hiddenEdit = true);
                $statement = get_analysis_statement($result);
                $('#personal-savings-calculate-modal p#calculation-result')
                .html($conclude);
                $('#personal-savings-calculate-modal p#calculation-analysis')
                .html($statement);
                if (!Modernizr.touch || !Modernizr.inputtypes.date) {
                    $('#personal-savings-calculate-modal input#edit-start-date').datepicker({
                        minDate: 0,
                        dateFormat: 'yy-mm-dd'
                    });
                }
                $('#personal-savings-calculate-modal select#edit-recurrence').selectize();
                $('#personal-savings-calculate-modal #myModalLabel p')
                .html('<h3 class="no-margin-top-bottom no-padding-top-bottom">' + $('input#name').val() + '</h3>');
                $('#personal-savings-calculate-modal').modal('show');
            }
        });

        $('#personal-savings-calculate-modal #recalculate').click(function() {
            var parent = $(this).parents('div.modal');
            parent.find('tr.edit-row').removeClass('hidden');
            $(this).hide();
            $(this).parent().addClass('text-info').html('Just Edit the Values and it will Update below');
        });

        $('#personal-savings-calculate-modal').on('change', '.editing-plan', function() {
            var parent = $('#personal-savings-calculate-modal');
            var $targetAmount = parent.find('table input#edit-target-amount').val();
            var $instalmentAmount = parent.find('table input#edit-instalment-amount').val();
            var $intervals = parent.find('table select#edit-recurrence').val();
            var $startDate = parent.find('table #edit-start-date').val();
            var $result = calculate_target_date($startDate, $targetAmount, $instalmentAmount, $intervals);
            if ($result) {
                $conclude = generate_analysis_html($result, $hiddenEdit = false);
                $statement = get_analysis_statement($result);
                parent.find('p#calculation-result').html($conclude);
                parent.find('p#calculation-analysis').html($statement);
                if (!Modernizr.touch || !Modernizr.inputtypes.date) {
                    $('#personal-savings-calculate-modal input#edit-start-date').datepicker({
                        minDate: 0,
                        dateFormat: 'yy-mm-dd'
                    });
                }
                $('#personal-savings-calculate-modal select#edit-recurrence').selectize();
            } 
        });

        $('#select-target-date').click(function () {
            $('input#target_date').val($('#current-target-date').html());
            $('#personal-savings-calculate-modal').modal('hide');
        });

        function calculate_target_date($startDate, $targetAmount, $instalmentAmount, $intervals) {
            if ($targetAmount > 0 && $instalmentAmount > 0) {
                var $result = {};
                $result.startDate = $startDate;
                $result.targetAmount = $targetAmount;
                $result.instalmentAmount = $instalmentAmount;
                $result.intervals = $intervals;
                var $duration = parseInt($targetAmount / $instalmentAmount);
                if ($intervals == 1) {
                    $recurrence = 'Daily';
                    $expectedDate = moment($startDate).add($duration, 'd');
                    $date = $expectedDate.format('ddd[.] Do MMM[,] YYYY');
                    $friendlyDate = $expectedDate.fromNow();
                } else if ($intervals == 2) {
                    $recurrence = 'Weekly';
                    $expectedDate = moment($startDate).add($duration, 'w');
                    $date = $expectedDate.format('ddd[.] Do MMM[,] YYYY');
                    $friendlyDate = $expectedDate.fromNow();
                } else if ($intervals == 3) {
                    $recurrence = 'Fortnightly (Every Two Weeks)';
                    $correctDuration = parseInt(2 * $duration);
                    $expectedDate = moment($startDate).add($correctDuration, 'w');
                    $date = $expectedDate.format('ddd[.] Do MMM[,] YYYY');
                    $friendlyDate = $expectedDate.fromNow();
                } else if ($intervals == 4) {
                    $recurrence = 'Monthly';
                    $expectedDate = moment($startDate).add($duration, 'M');
                    $date = $expectedDate.format('ddd[.] Do MMM[,] YYYY');
                    $friendlyDate = $expectedDate.fromNow();
                }
                $result.recurrence = $recurrence;
                $result.expectedDate = $expectedDate;
                $result.date = $date;
                $result.friendlyDate = $friendlyDate;
                return $result;
            } else {
                return false;
            }
        }

        function generate_recurrence_select_input($recurrence) {
            $periods = ['Daily', 'Weekly', 'Fortnightly (Every Two Weeks)', 'Monthly']
            var $options = "";
            var selected = "";
            var count = 1;
            for (i = 0; i < $periods.length; i++) {
                if ($recurrence == $periods[i]) {
                    selected = "selected";
                } else {
                    selected = '';
                }
                $options +='<option value="' + count + '" ' + selected + '>' + $periods[i] + '</option>';
                count++;
            }
            return '<select class="form-control editing-plan" id="edit-recurrence">' + $options + '</select>';
        }

        function generate_analysis_html($result, $hiddenEdit = true) {
            $editSection = ($hiddenEdit) ? 'hidden' : '';
            $conclude = '<table class="table table-responsive table-striped table-condensed no-margin-bottom">' +
            '<thead><tr><th>Start Date </th><th>Instalment Pattern</th><th>Target Amount</th><th>Instalment Amount</th></tr></thead>' +
            '<tbody><tr><td>' + moment($result.startDate).format('ddd[.] Do MMM[,] YYYY') + 
            '<br />(' + moment($result.startDate).fromNow() + ')</td><td>' + $result.recurrence + '</td><td>' +
            $result.targetAmount + '</td><td>' + $result.instalmentAmount + '</td></tr>' +
            '<tr class="edit-row ' + $editSection + '">' +
            '<td><input class="form-control editing-plan" type="text" id="edit-start-date" value="' + $result.startDate +'"></td>' +
            '<td>' + generate_recurrence_select_input($result.recurrence) + '</td>' +
            '<td><input class="form-control editing-plan" type="text" id="edit-target-amount" value="' + $result.targetAmount +'"></td>' +
            '<td><input class="form-control editing-plan" type="text" id="edit-instalment-amount" value="' + $result.instalmentAmount +'"></td>' +
            '</tr>' +
            '</tbody></table>';
            return $conclude;
        }

        function get_analysis_statement($result) {
            $statement = '<hr class="center-block half-width margin-top-lg margin-bottom-xs"/><div class="text-center margin-top-md">Expected Date To Reach Target: <h3 class="no-margin-top">' + $result.date + '<br /><small>(' + $result.friendlyDate + ')</small></h3></div>' +
            '<span class="hidden" id="current-target-date">' + $result.expectedDate.format('YYYY-MM-DD') + '</span>';                
            return $statement;
        }
    });
</script>
