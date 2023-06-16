$(document).ready(function() {

    var tbl_denum = $('#tbl_denum').DataTable({
        autoWidth: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        lengthChange: false,
        paging: false,
        bInfo: false,
        searching: false,
        bDestroy: true,
        ajax: {
            url: WebURL + '/tally-get',
            method: 'POST',
            datatype: 'json',

            data: function (data) {
                var ctsNo = $('#CTSNo').val();
                var filter_emp  = $('#filter_emp').val();
                var filter_shift  = $('#filter_shift').val();
                data.filter_emp  = filter_emp;
                data.filter_shift = filter_shift;
                data.ctsNo = ctsNo;

            },
            beforeSend: function () {
                $('#tbl_denum > tbody').html(
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
            {data:'Amount',
                render: function (data, type, row, meta) {
                return (row.DenomOption_ID ==  13 ) ? '<span style="float:left;!important" ;><b>Bills</b></span> ' + parseFloat(row.Amount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) : ((row.DenomOption_ID ==  7) ?  '<span style="float:left;!important" ;><b>Coins</b></span> ' + row.Amount : row.Amount);
            }
            },
            {data:'P1_Qty',
                render: function (data, type, row, meta) {
                    return (row.P1_Qty > 0) ? row.P1_Qty : '-';
                }
            },
            {data:'P1_Amount',
                render: function (data, type, row, meta) {
                return (row.P1_Amount > 0) ? parseFloat(row.P1_Amount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) : '-' ;
                }
            },
            {data:'P2_Qty',
                render: function (data, type, row, meta) {
                return (row.P2_Qty > 0) ? row.P2_Qty : '-';
                }
            },
            {data:'P2_Amount',
                render: function (data, type, row, meta) {
                return (row.P2_Amount > 0) ? parseFloat(row.P2_Amount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) : '-' ;
                }
            },
            {data:'P3_Qty',
                render: function (data, type, row, meta) {
                return (row.P3_Qty > 0) ? row.P3_Qty : '-';
                }
            },
            {data:'P3_Amount',
                render: function (data, type, row, meta) {
                return (row.P3_Amount > 0) ? parseFloat(row.P3_Amount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) : '-' ;
                }
            },
            {data:'P4_Qty',
                render: function (data, type, row, meta) {
                return (row.P4_Qty > 0) ? row.P4_Qty : '-';
                }
            },
            {data:'P4_Amount',
                render: function (data, type, row, meta) {
                return (row.P4_Amount > 0) ? parseFloat(row.P4_Amount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) : '-' ;
                }
            },
            {data:'P5_Qty',
                render: function (data, type, row, meta) {
                return (row.P5_Qty > 0) ? row.P5_Qty : '-';
                }
            },
            {data:'P5_Amount',
                render: function (data, type, row, meta) {
                return (row.P5_Amount > 0) ? parseFloat(row.P5_Amount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) : '-' ;
                }
            },
            {
                render: function (data, type, row, meta) {

                    totqty = (parseInt(row.P1_Qty) || 0) + (parseInt(row.P2_Qty) || 0) + (parseInt(row.P3_Qty) || 0) + (parseInt(row.P4_Qty) || 0) + (parseInt(row.P5_Qty) || 0);
                    return (totqty > 0) ? totqty : '-';
                }
            },
            {
                render: function (data, type, row, meta) {

                    totamt = (parseFloat(row.P1_Amount) || 0) + (parseFloat(row.P2_Amount) || 0) + (parseFloat(row.P3_Amount) || 0) + (parseFloat(row.P4_Amount) || 0) + (parseFloat(row.P5_Amount) || 0);
                    return (totamt > 0) ? parseFloat(totamt).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }) : '-' ;
                }
            },
        ],
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            var api = this.api();
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            tot1 = api
                .column(2)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            tot2 = api
                .column(4)
                .data()
                .reduce( function (a, b) {
                return intVal(a) + intVal(b);
                }, 0 );


            tot3 = api
                .column(6)
                .data()
                .reduce( function (a, b) {
                return intVal(a) + intVal(b);
                }, 0 );


            tot4 = api
            .column(8)
            .data()
            .reduce( function (a, b) {
            return intVal(a) + intVal(b);
            }, 0 );


            tot5 = api
                .column(10)
                .data()
                .reduce( function (a, b) {
                return intVal(a) + intVal(b);
                }, 0 );


            var totamt = tot1+tot2+tot3+tot4+tot5;
            var arr = api.data().toArray()
            var lcfs = (arr[0].LCF > 0) ? parseFloat(arr[0].LCF).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }) : '-' ;
            var lccs = (arr[0].LCC > 0) ? parseFloat(arr[0].LCC).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }) : '-' ;

            var lcc = (arr[0].LCC > 0) ? parseFloat(arr[0].LCC) : 0;
            var lcf = (arr[0].LCF > 0) ? parseFloat(arr[0].LCF) : 0;


            var tcs = totamt - ((lcf > 0) ? lcf : 0)
            var net = tcs - ((lcc > 0) ? lcc : 0)

            $(api.column(2).footer()).html(tot1.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              })).addClass('text-right');
            $(api.column(4).footer()).html(tot2.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              })).addClass('text-right');
            $(api.column(6).footer()).html(tot3.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              })).addClass('text-right');
            $(api.column(8).footer()).html(tot4.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              })).addClass('text-right');
            $(api.column(10).footer()).html(tot5.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              })).addClass('text-right');
            $(api.column(12).footer()).html(totamt.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              })).addClass('text-right');

            $('#lcf', api.table().footer()).html(lcfs).addClass('text-right');
            $('#tcs', api.table().footer()).html(tcs.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              })).addClass('text-right');
            $('#lcc', api.table().footer()).html(lccs).addClass('text-right');
            $('#net', api.table().footer()).html(net.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              })).addClass('text-right');

              var shift = $("#filter_shift option:selected").html();;
              var tshift = shift + ' SHIFT';

              $('#t-shift').text(tshift);


        },
        "createdRow": function( row, data, dataIndex ) {

            // Add a class to the cell in the second column
            $(row).children(':nth-child(1)').addClass('text-right');
            $(row).children(':nth-child(3)').addClass('text-right');
            $(row).children(':nth-child(5)').addClass('text-right');
            $(row).children(':nth-child(7)').addClass('text-right');
            $(row).children(':nth-child(9)').addClass('text-right');
            $(row).children(':nth-child(11)').addClass('text-right');
            $(row).children(':nth-child(13)').addClass('text-right');
            // Add a class to the row
            $(row).addClass('important');

        },



    });

    $('#btn_filter_tally').on('click', function () {
        $('#modal_filter_tally').modal('hide');
        // tbl_denum.destroy()
        tbl_denum.draw()

    });

    $('#printcts').on('click', function(){

        var lcf = ($('#lcf').text());

        if(lcf.length > 1)
        {
            ctsNo = $('#CTSNo').val(),
            shift = $('#filter_shift').val();
            purl = WebURL + '/cts-print/' +ctsNo+ '/' + shift
            window.open(purl, '_blank');
        }
        else
        {
            swal.fire("Incomplete Tally" ,"Change the filter or endshift first" , "warning");
        }

    })




    ///////
});

