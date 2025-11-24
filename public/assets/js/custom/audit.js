$(document).ready(function () {
    $(".select2").select2();

    var date1 = $("#filter_dateFrom").flatpickr({
        onChange: function (selectedDates, dateStr, instance) {
            date2.set("minDate", dateStr);
        },
    });
    var date2 = $("#filter_dateTo").flatpickr({
        onChange: function (selectedDates, dateStr, instance) {
            date1.set("maxDate", dateStr);
        },
    });

    $("#modal_filter_mcts").on("hidden.bs.modal", function () {
        $("#filter_store").val(0);
    });

    var selectOptions = [];

    $.ajax({
        url: WebURL + "/status-get",
        type: "GET",
        dataType: "json",
        success: function (data) {
            selectOptions = data;
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });

    function formatLoading() {
        return `<div class="p-2 text-muted">Loading data...</div>`;
    }


    var tbl_audit = $("#tbl_audit").DataTable({
        autoWidth: true,
        serverSide: true,
        searching: false,
        scrollX: true,
        ordering: false,
        lengthChange: false,
        ajax: {
            url: WebURL + "/audit-get",
            method: "POST",
            datatype: "json",
            data: function (data) {
                data.filter_dateFrom = $("#filter_dateFrom").val();
                data.filter_dateTo = $("#filter_dateTo").val();
                data.filter_store = $("#filter_store").val();
                data.filter_am = $("#filter_am").val();
                data.filter_ac = $("#filter_ac").val();
                data.filter_status = $("#filter_status").val();
            },
            beforeSend: function () {
                $("#tbl_audit > tbody").html(
                    '<tr class="odd">' +
                    '<td valign="top" colspan="7" class="dataTables_empty"><div class="text-center"><div class="spinner spinner-border"></div></div></td>' +
                    "</tr>"
                );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 419) {
                    alert("Session Expired. Kindly Relogin Again.");
                } else {
                    alert(
                        "Processing data failed. Please report to the System Adminstator."
                    );
                }
            },
        },
        language: {
            emptyTable: "No data available.",
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        columns: [{
                className: "details-control",
                orderable: false,
                data: null,
                defaultContent: "",
            },
            {
                data: "LocationCode",
                render: function (data, type, row, meta) {
                    return row.LocationCode + " - " + row.Location;
                },
            },
            {
                data: "Sched"
            },
            {
                //Treasury Findings
                data: "SalesDate",
                className: "text-right",
                // render: function (data, type, row, meta) {
                //     btn =
                //         '<a href="javascript:void(0)" class="text-info"  data-toggle="modal"  data-target="#modal_ir" data-locID="' +
                //         row.Location_ID +
                //         '" data-salesDate="' +
                //         row.SalesDate +
                //         '" >' +
                //         row.SalesDate +
                //         "</a>";
                //     return btn;
                // },
            },
            {
                //Status
                render: function (data, type, row, meta) {
                    var selectHTML =
                        '<select class="select2 statOpt"> <option></option>';
                    for (var i = 0; i < selectOptions.length; i++) {
                        if (row.Status_ID == selectOptions[i].Status_ID) {
                            selectHTML +=
                                '<option value="' +
                                selectOptions[i].Status_ID +
                                '"selected>' +
                                selectOptions[i].Status +
                                "</option>";
                        } else {
                            selectHTML +=
                                '<option value="' +
                                selectOptions[i].Status_ID +
                                '">' +
                                selectOptions[i].Status +
                                "</option>";
                        }
                    }
                    selectHTML += "</select>";
                    return selectHTML;
                },
            },
            {
                // Treasury Remarks
                render: function (data, type, row, meta) {
                    btn =
                        '<a href="javascript:void(0)" class="action-icon text-primary"  data-toggle="modal"  data-target="#modal_remarks" data-remarks="' +
                        row.Remarks +
                        '" data-locID="' +
                        row.Location_ID +
                        '" data-salesDate="' +
                        row.SalesDate +
                        '" ><i class="mdi mdi-chat-processing-outline mdi-36px"></i></a>';
                    return btn;
                },
            },
            {
                data: "TotalSales",
                className: "text-right",
                render: function (data, type, row, meta) {
                    return row.TotalSales > 0 ?
                        parseFloat(row.TotalSales).toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        }) :
                        "";
                },
            },
            {
                data: "NetCash",
                className: "text-right",
                render: function (data, type, row, meta) {
                    return row.NetCash > 0 ?
                        parseFloat(row.NetCash).toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        }) :
                        "";
                },
            },
            {
                data: "DepositAmount",
                render: function (data, type, row, meta) {
                    DepositAmount = parseFloat(
                        row.DepositAmount
                    ).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                    return row.DepositAmount > 0 ?
                        '<a href="javascript:void(0)" data-image="1|' +
                        row.Deposit_ID +
                        "|" +
                        row.Location_ID +
                        '" data-toggle="modal" data-target="#modal_dpas" class=" text-info">' +
                        DepositAmount +
                        "</a>" :
                        "";
                },
                className: "text-right",
            },
            {
                data: "VDA",
                render: function (data, type, row, meta) {
                    VDepositAmount = parseFloat(row.VDA).toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        }
                    );
                    var VDA =
                        row.VDA > 0 ?
                        '<a href="javascript:void(0)" data-image="2|' +
                        row.ValidatedDeposit_ID +
                        "|" +
                        row.Location_ID +
                        '" data-toggle="modal" data-target="#modal_dpas" class=" text-info">' +
                        VDepositAmount +
                        "</a>" :
                        "";
                    return VDA;
                },
                className: "text-right",
            },
            {
                data: "Discrepancy",
                className: "text-right",
                render: function (data, type, row, meta) {
                    return row.Discrepancy ?
                        parseFloat(row.Discrepancy).toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            }
                        ) :
                        "";
                },
            },
        ],
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
            $(".select2").select2();
        },
        createdRow: function (row, data, dataIndex) {
            if (data.Discrepancy < 0) {
                $(row).children(":nth-child(11)").addClass("text-danger");
            } else if (data.Discrepancy > 0) {
                $(row).children(":nth-child(11)").addClass("text-primary");
            }
        },
    });

    $("#tbl_audit tbody").on("click", "td.details-control", function () {
        var tr = $(this).closest("tr");
        var row = tbl_audit.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass("shown");
        } else {
            // Show loading placeholder
            row.child(formatLoading()).show();
            tr.addClass("shown");

            // Fetch real data
            var rowData = row.data();
            var remoteLink =
                WebURL +
                "/get-ir/" +
                rowData.Location_ID +
                "/" +
                rowData.SalesDate;

            $.ajax({
                url: remoteLink,
                success: function (response) {
                    if (!Array.isArray(response) || response.length === 0) {
                        row.child(
                            '<div class="p-2 text-muted">No records found.</div>'
                        ).show();
                        return;
                    }

                    let table = `
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>SALES DATE</th>
                                    <th>CASHIER</th>
                                    <th>SHIFT</th>
                                    <th>POS</th>
                                    <th>CDR / CASH ON HAND</th>
                                    <th>DISCREPANCY</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>`;

                    response.forEach(function (r) {
                        const discrepancy = r.COH - r.CDR;
                        const discrepancyColor =
                            discrepancy > 0 ? "blue" : (discrepancy < 0 ? "red" : "green");

                        // Only show the eye icon if discrepancy is between -199 and 199
                        const showEyeIcon = discrepancy >= -199 && discrepancy <= 199;
                        const eyeIconHtml = !showEyeIcon ?
                            `<a href="javascript:void(0)" class="text-info" data-id="${
                                r.CLK_ID
                            }" data-toggle='modal' data-target='#modal_ir' data-popup='tooltip' title='View' data-placement='right'>
                                <i class="mdi mdi-eye mdi-24px"></i>
                            </a>` : '';

                        table += `
                            <tr>
                                <td>
                                    ${eyeIconHtml}
                                </td>
                                <td>${r.SalesDate}</td>
                                <td>${r.Employee2}</td>
                                <td>${r.Shift}</td>
                                <td>${parseFloat(r.CDR).toLocaleString(
                                    undefined,
                                    { minimumFractionDigits: 2 }
                                )}</td>
                                <td>${parseFloat(r.COH).toLocaleString(
                                    undefined,
                                    { minimumFractionDigits: 2 }
                                )}</td>
                                <td style="color:${discrepancyColor};">${discrepancy.toLocaleString(
                            undefined,
                            { minimumFractionDigits: 2 }
                        )}</td>
                                <td>${r.Status ?? ""}</td>
                            </tr>`;
                    });

                    table += `</tbody></table>`;

                    row.child(table).show();
                },

                error: function () {
                    row.child(
                        '<div class="p-2 text-danger">Failed to load data.</div>'
                    ).show();
                },
            });
        }
    });

    tbl_audit.on("change", ".statOpt", function () {
        var data = tbl_audit.row($(this).parents("tr")).data();
        var status = $(this).val();

        var locID = data.Location_ID;
        var salesDate = data.SalesDate;

        $.ajax({
            url: WebURL + "/status-insert",
            type: "POST",
            dataType: "json",
            data: {
                locID: locID,
                salesDate: salesDate,
                status: status
            },
            success: function (data) {},
            error: function (xhr, status, error) {},
        });
    });

    $("#btn_filter_audit").on("click", function () {
        $("#modal_filter_audit").modal("hide");
        var title = "";

        if ($("#filter_store").val() != 0) {
            title = $("#filter_store option:selected").text();
        } else {
            if ($("#filter_dc").val() != 0) {
                if ($("#filter_am").val() != 0) {
                    if ($("#filter_ac").val() != 0) {
                        title =
                            "AC : " + $("#filter_ac option:selected").text();
                    } else {
                        title =
                            "AM : " + $("#filter_am option:selected").text();
                    }
                } else {
                    title = $("#filter_dc option:selected").text();
                }
            }
        }

        $("#filter_title").text(title);
        tbl_audit.draw();
    });

    $("#audit_dl").on("click", function () {
        if (tbl_audit.data().any()) {
            var dateFrom = $("#filter_dateFrom").val();
            var dateTo = $("#filter_dateTo").val();
            var store = $("#filter_store").val();
            var param = btoa(dateFrom + "@@" + dateTo + "@@" + store);

            $(window.location).attr("href", WebURL + "/audit-dl/" + param);
        } else {
            swal.fire("Empty Report", "Filter first", "warning");
        }
    });

    $("#modal_dpas").on("show.bs.modal", function (e) {
        var img = $(e.relatedTarget).data("image");
        var res = img.split("|");
        $.post(
            WebURL + "/image-get", {
                res
            },
            function (data) {
                $("#loader").hide();
                $("#attachment").show();
                $("#attachment").attr("src", data[0].Image);
                $("#uRemarks").text(data[0].Remarks);
                $("#uploadDate").text(data[0].InsertDate);
                $("#uploadBy").text(data[0].InsertBy);
            },
            "JSON"
        );
    });

    $("#modal_dpas").on("hide.bs.modal", function (e) {
        $("#loader").show();
        $("#attachment").hide();
        $("#attachment").attr("src", "");
    });

    $("#modal_remarks").on("show.bs.modal", function (e) {
        var remarks = $(e.relatedTarget).data("remarks") ?? "Empty";
        var salesDate = $(e.relatedTarget).data("salesdate");
        var locID = $(e.relatedTarget).data("locid");
        $("#tRemarks").html(remarks.replace(/\\n/g, "\n\r"));
        $("#locID").val(locID);
        $("#salesDate").val(salesDate);
        $("#new_tRemarks").val("");
    });

    $("#modal_ir").on("shown.bs.modal", (e) => {
        var id = $(e.relatedTarget).data("id");
        var remoteLink =
            WebURL + "/show-ir/" + id;
        $("#modal_ir")
            .find(".modal-body")
            .html(
                '<div class="text-center"><div class="spinner spinner-border"></div></div>'
            );
        $("#modal_ir")
            .find(".modal-body")
            .load(remoteLink, function () {

                $("input[required],select[required],text-area[required]")
                    .closest(".form-group")
                    .prev()
                    .addClass("label-required");

                $("#modal_ir .select2").select2({
                    dropdownParent: $("#modal_ir"),
                });


                $("#btnIRSave").on("click", function () {
                    var error = false;
                    var status = $("#ir_status").val();

                    console.log(status);

                    if (status <= 0) {
                        console.log('error stats')
                        error = true;
                        $('#ir_status').addClass('error-input');
                        $('#ir_status_error').show();
                    } else {
                        $('#ir_status').removeClass('error-input');
                        $('#ir_status_error').hide();
                    }

                    if (error == false) {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You want to save Treasury Findings?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#2196F3",
                            confirmButtonText: "Yes",
                            cancelButtonText: "Cancel",
                            allowOutsideClick: () => !Swal.isLoading(),
                            showLoaderOnConfirm: true,
                            preConfirm: async () => {
                                try {
                                    var formdata = $("#irForm").serialize();
                                    const data = await $.ajax({
                                        type: "POST",
                                        url: WebURL + "/ir-save",
                                        data: formdata,
                                        dataType: "json"
                                    });
                                    if (parseInt(data.num) > 0) {
                                        return data.msg;
                                    } else {
                                        throw new Error(data.msg);
                                    }
                                } catch (err) {
                                    Swal.showValidationMessage(err.message || err);
                                    throw err;
                                }
                            }
                        }).then((result) => {
                            if (result.value) {
                                Swal.fire({
                                    title: "Success",
                                    text: result.value,
                                    icon: "success",
                                    confirmButtonColor: "#2E7D32",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        });

                    }
                });

            });
        $(document).off("focusin.modal");
    });

    $("#btn_new_rem").on("click", function () {
        var error = false;
        var new_tRemarks = $("#new_tRemarks").val();

        if ($.trim(new_tRemarks).length == 0) {
            error = true;
            $("#new_tRemarks").addClass("error-input");
            $("#new_tRemarks_error").show();
        } else {
            $("#new_tRemarks").removeClass("error-input");
            $("#new_tRemarks_error").hide();
        }

        if (error == false) {
            $(".invalid-feedback").hide();
            $(this).attr("disabled", true);
            $(this).text("Saving...");
            swal.fire({
                title: "Are you sure?",
                text: "Saving new Remarks",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.value) {
                    var formdata = $("#form_new_tRemarks").serialize();
                    $.post(
                        WebURL + "/status-insert",
                        formdata,
                        function (data) {
                            if (data.num > 0) {
                                swal.fire({
                                    title: "Success",
                                    text: data.msg,
                                    icon: "success",
                                    confirmButtonText: "Ok",
                                }).then(function (result) {
                                    if (true) {
                                        $("#modal_remarks").modal("hide");
                                        tbl_audit.ajax.reload(null, false);
                                        $("#btn_new_rem").attr(
                                            "disabled",
                                            false
                                        );
                                        $("#btn_new_rem").text("Save");
                                        $("#new_tRemarks").val("");
                                    }
                                });
                            } else {
                                swal.fire({
                                    title: "Warning!",
                                    text: data.msg,
                                    icon: "warning",
                                    confirmButtonText: "Ok",
                                    confirmButtonColor: "#6658dd",
                                    allowOutsideClick: false,
                                });
                            }
                        },
                        "JSON"
                    );
                } else {
                    $("#btn_new_rem").attr("disabled", false);
                    $("#btn_new_rem").text("Save");
                }
            });
        } else {
            $(".error-input").filter(":first").focus();
        }
    });

    $("#filter_dc").on("change", function () {
        var dc = $("#filter_dc").val();
        $.ajax({
            url: WebURL + "/am-get",
            type: "POST",
            dataType: "text",
            data: {
                dc: dc
            },
            cache: false,
            success: function (data) {
                $("#filter_am").html(data);
                $("#filter_store").html("<option></option>");
                $("#filter_ac").html("<option></option>");
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $("#filter_am").on("change", function () {
        var am = $("#filter_am").val();
        $.ajax({
            url: WebURL + "/ac-get",
            type: "POST",
            dataType: "text",
            data: {
                am: am
            },
            cache: false,
            success: function (data) {
                $("#filter_ac").html(data);
                $("#filter_store").html("<option></option>");
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $("#filter_ac").on("change", function () {
        var ac = $("#filter_ac").val();
        $.ajax({
            url: WebURL + "/storeac-get",
            type: "POST",
            dataType: "text",
            data: {
                ac: ac
            },
            cache: false,
            success: function (data) {
                $("#filter_store").html(data);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    function checkDownloadStart() {
        $.ajax({
            url: WebURL + '/check-download-start',
            success: function(response) {
                if (response.download_started) {
                    $.ajax({
                        url: WebURL + '/dl-finish',
                    });
                    Swal.close();
                } else {
                    // Check again after a delay
                    setTimeout(checkDownloadStart, 1000);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr, status, error);
                // Handle errors if necessary
            }
        });
    }

    $("#btn_generate_ir").on("click", function () {
        $(".invalid-feedback").hide();

        var loc = $("#filter_store").val();
        var dfrom = $("#filter_dateFrom").val();
        var dto = $("#filter_dateTo").val();
        var dc = $("#filter_dc").val();
        var am = $("#filter_am").val();
        var ac = $("#filter_ac").val();


        var error = false;

        if (dfrom.length <= 0) {
            error = true;
            $("#filter_dateFrom_error").removeClass("hide");
        } else {
            $("#filter_dateFrom_error").addClass("hide");
        }

        if (dto.length <= 0) {
            error = true;
            $("#filter_dateTo").removeClass("hide");
        } else {
            $("#filter_dateTo").addClass("hide");
        }

        if (error == false) {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            });

            $(window.location).attr(
                "href",
                WebURL + "/report/ir/" + loc + "@@" + dfrom + "@@" + dto + "@@" + dc + "@@" + am + "@@" + ac
            );
            checkDownloadStart();
        } else {
            // $("#rpt_ic_dc_error").show();
        }
    });

    ///////
});
