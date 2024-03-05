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

function showModal(header,body,footer){
    $('#modalHeader').html(header)
    $('#modalBody').html(body)
    $('#modalFooter').html(footer)
    $('#modal').modal("show")
}

function closeModal()
{
    $('#modal').modal('hide')
}
function showFullModal(header,body,footer){
    $('#modalHeaderF').html(header)
    $('#modalBodyF').html(body)
    $('#modalFooterF').html(footer)
    $('#modalF').modal("show")
}
function closeFullModal()
{
    $('#modalF').modal('hide')
}

function dateNow(){
    let currentDate = new Date();
    let year = currentDate.getFullYear();
    let month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Tambahkan '0' di depan jika bulan < 10
    let day = String(currentDate.getDate()).padStart(2, '0'); // Tambahkan '0' di depan jika tanggal < 10
    return `${year}-${month}-${day}`
}