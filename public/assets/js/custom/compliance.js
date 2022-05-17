
$(document).ready(function() {

    $('#filter_store').select2();

    var date1 = $("#filter_dateFrom").flatpickr({
        maxDate:"today",
        onChange: function(selectedDates, dateStr, instance) {
            date2.set('minDate', dateStr)
          }
    })

    var date2 = $("#filter_dateTo").flatpickr({
        maxDate:"today",
        onChange: function(selectedDates, dateStr, instance) {
            date1.set('maxDate', dateStr)
          }
    })


    var tbl_comp = $('#tbl_comp').DataTable({
        autoWidth: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        lengthChange: false,
        searching: false,
        ajax: {
            url: WebURL + '/compliance-get',
            method: 'POST',
            datatype: 'json',
            data: function (data) {
                var filter_dateFrom  = $('#filter_dateFrom').val();
                var filter_dateTo  = $('#filter_dateTo').val();
                var filter_store = $('#filter_store').val();
                data.filter_dateFrom  = filter_dateFrom;
                data.filter_dateTo = filter_dateTo;
                data.filter_store = filter_store;

            },
            beforeSend: function () {
                $('#tbl_comp > tbody').html(
                    '<tr class="odd">' +
                    '<td valign="top" colspan="7" class="dataTables_empty"><div class="text-center"><div class="spinner spinner-border"></div></div></td>' +
                    '</tr>'
                );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Processing data failed. Please report to the System Adminstator.");
            },

        },
        language: {
            emptyTable: 'No data available.',
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        columns: [
            {data:"DateRange"},
            {data:"GY",
            render: function (data, type, row, meta) {
                var icon = ''
                if (row.GY == 1)
                {
                    icon = '<div class="text-success">&check;</div>';
                }
                else if (row.GY == 0)
                {
                    icon = '<div class="text-danger">&#10006;</div>';
                }
                else
                {
                    icon = '<div class="text-secondary"> - </div>';
                }
                return  icon;
            },
            },
            {data:"Opening",
            render: function (data, type, row, meta) {
                var icon = ''
                if (row.Opening == 1)
                {
                    icon = '<div class="text-success">&check;</div>';
                }
                else
                {
                    icon = '<div class="text-danger">&#10006;</div>';
                }
                return  icon;
            },},
            {data:"Mid",
            render: function (data, type, row, meta) {
                var icon = ''
                if (row.Mid == 1)
                {
                    icon = '<div class="text-success">&check;</div>';
                }
                else
                {
                    icon = '<div class="text-danger">&#10006;</div>';
                }
                return  icon;
            },},
            {data:"Closing",
            render: function (data, type, row, meta) {
                var icon = ''
                if (row.Closing == 1)
                {
                    icon = '<div class="text-success">&check;</div>';
                }
                else
                {
                    icon = '<div class="text-danger">&#10006;</div>';
                }
                return  icon;
            },},
            {data:"OverAll",
            render: function (data, type, row, meta) {
                var icon = ''
                if (row.OverAll == 1)
                {
                    icon = '<div class="text-success">&check;</div>';
                }
                else
                {
                    icon = '<div class="text-danger">&#10006;</div>';
                }
                return  icon;
            },}

        ],
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        },

    });

    $('#btn_filter_comp').on('click', function () {
        $('#modal_filter_comp').modal('hide');
        tbl_comp.draw();
    });

    $('#comp_dl').on('click',function(){

        if(tbl_comp.data().any())
        {
            var dateFrom = $('#filter_dateFrom').val();
            var dateTo = $('#filter_dateTo').val();
            var store = $('#filter_store').val();
            var param = btoa(dateFrom+'@@'+dateTo+'@@'+store)

            $(window.location).attr('href', WebURL + '/compliance-dl/'+param);
        }
        else
        {
            swal.fire("Empty Report" ,"Filter first" , "warning");
        }



    })




///////
});
