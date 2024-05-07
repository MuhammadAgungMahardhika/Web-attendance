@extends('template.layout-1-column.main')
@section('container')
    <section class="section p-2">
        <div class="row" id="row-history">

        </div>

    </section>
    <script>
        showAttendanceHistory()

        function showAttendanceHistory() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: baseUrl + "/" + `api/attendance-by-user/{{ $user_id }}`,
                success: function(response) {
                    let userAttendanceHistory = response.data;


                    if (userAttendanceHistory.length == 0) {
                        console.log("masuk sini")
                        return $("#row-history").html(` <div class="col-12 col-sm-12 col-md-4 col-lg3">
                                <div class="card shadow-sm bg-primary">
                                    <div class="card-body table-responsive">
                                        <p class="text-white">No attendance data found<p>
                                    </div>
                                </div>
                            </div>`);
                    }
                    let data = "";
                    for (let i = 0; i < userAttendanceHistory.length; i++) {
                        let {
                            id,
                            user_id,
                            user,
                            shift,
                            checkin,
                            checkout,
                            date,
                            status_attendance,
                            work_from,
                        } = userAttendanceHistory[i];

                        let statusBadge = "";
                        if (status_attendance == "on time") {
                            statusBadge = "badge bg-success";
                        } else {
                            statusBadge = "badge bg-warning";
                        }
                        data += `
                        <div class="col-12">
                            <div class="card shadow-sm bg-primary">
                                <div class="card-body table-responsive">
                                    <table class="table table-borderless">
                                        <tbody class="text-sm" id="table-history">
                                            <tr>
                                                <td class="text-white">Date</td>
                                                <td colspan="2" class="text-white">${date != null ? date : ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white">Checkin</td>
                                                <td colspan="2" class="text-white">${checkin != null ? checkin : ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white">Checkout</td>
                                                <td colspan="2" class="text-white">${checkout != null ? checkout : ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white">Shift</td>
                                                <td colspan="2" class="text-white">${shift.name} (${shift.start} - ${shift.end})</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"> Work From </td>
                                                <td colspan="2" class="text-white">${work_from != null ? work_from : ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white">Status</td>
                                                <td colspan="2" class="text-white"><span class="${statusBadge}">${status_attendance != null ? status_attendance : ''}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                            `;
                    }
                    return $("#row-history").html(data);

                },
                error: function(err) {
                    let errorResponse = JSON.parse(err.responseText);
                    const errorMessage = errorResponse.message;
                    showToastErrorAlert(errorMessage);
                },
            });
        }
    </script>
@endsection
