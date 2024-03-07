function showToastErrorAlert(message, action = null) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });
    return Toast.fire({
        icon: "error",
        title: message,
    }).then(
        setTimeout(() => {
            action;
        }, 3000)
    );
}
function showToastSuccessAlert(message, action = null) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });
    return Toast.fire({
        icon: "success",
        title: message,
    }).then(
        setTimeout(() => {
            action;
        }, 3000)
    );
}
function showToastWarningAlert(message, action = null) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });
    return Toast.fire({
        icon: "warning",
        title: message,
    }).then(
        setTimeout(() => {
            action;
        }, 3000)
    );
}

function showErrorAlert(message) {
    return Swal.fire({
        position: "top-end",
        icon: "error",
        title: message,
        showConfirmButton: false,
        timer: 1500,
    });
}

function showSuccessAlert(message) {
    return Swal.fire({
        position: "top-end",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 1500,
    });
}

function showModal(header, body, footer) {
    $("#modalHeader").html(header);
    $("#modalBody").html(body);
    $("#modalFooter").html(footer);
    $("#modal").modal("show");
}

function closeModal() {
    $("#modal").modal("hide");
}
function showFullModal(header, body, footer) {
    $("#modalHeaderF").html(header);
    $("#modalBodyF").html(body);
    $("#modalFooterF").html(footer);
    $("#modalF").modal("show");
}
function closeFullModal() {
    $("#modalF").modal("hide");
}

function dateNow() {
    let currentDate = new Date();
    let year = currentDate.getFullYear();
    let month = String(currentDate.getMonth() + 1).padStart(2, "0"); // Tambahkan '0' di depan jika bulan < 10
    let day = String(currentDate.getDate()).padStart(2, "0"); // Tambahkan '0' di depan jika tanggal < 10
    return `${year}-${month}-${day}`;
}

function convertTimeToHiFormat(string) {
    let parts = string.split(":"); // Membagi string berdasarkan karakter ':'
    let hour = parseInt(parts[0]); // Mengambil jam (bagian pertama)
    let minute = parseInt(parts[1]); // Mengambil menit (bagian kedua)

    // Membentuk string waktu dengan format HH:mm
    let formattedTime =
        hour.toString().padStart(2, "0") +
        ":" +
        minute.toString().padStart(2, "0");
    return formattedTime;
}
