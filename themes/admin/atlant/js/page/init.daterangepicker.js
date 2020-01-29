$(function() {

    var start = moment(START_DATE, "MM-DD-YYYY");
    var end = moment(END_DATE, "MM-DD-YYYY");

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'This Year': [moment().startOf('year'), moment().endOf('year')],
        }
    }, cb);

    cb(start, end);
    
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
      awal = picker.startDate.format('YYYY-MM-DD');
      akhir = picker.endDate.format('YYYY-MM-DD');
      URL_UPDATE = CURRENT_URL+"?start="+awal+"&end="+akhir;
      document.location=URL_UPDATE;
    });

});