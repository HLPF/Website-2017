<script src="JS/Bootstrap/bootstrap.min.js"></script>

<script type="text/javascript" src="JS/Bootstrap/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="JS/Bootstrap/bootstrap-datetimepicker.da.js" charset="UTF-8"></script>

<script type="text/javascript">
    $('.picker').datetimepicker({
      language:  'da',
      weekStart: 1,
      todayBtn:  1,
		  autoclose: 1,
		  todayHighlight: 1,
		  startView: 2,
		  forceParse: 0,
      showMeridian: 1
    });
</script>

<script type="text/javascript">
    $('.birthdayPicker').datetimepicker({
      language:  'da',
      startView: 4,
      minView: 2,
      maxView: 4,
      format: 'dd-mm-yyyy',
      autoclose: 1,
    });
</script>