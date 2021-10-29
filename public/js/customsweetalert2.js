const CustomErrorSwal = (titleParam, textParam) => {
    Swal.fire({
        customClass: {
            title: 'swal-white-text',
            content: 'swal-white-text',
        },
        icon: 'error',
        title: titleParam,
        text: textParam,
        showConfirmButton: false,
        background: '#df4759',
        position: 'top-end',
        toast: true,
        timer: 3500,
        timerProgressBar: true,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    });
}

const CustomSuccessSwal = (titleParam, textParam) => {
    Swal.fire({
        customClass: {
            title: 'swal-white-text',
            content: 'swal-white-text',
        },
        icon: 'success',
        title: titleParam,
        text: textParam,
        showConfirmButton: false,
        background: '#42ba96',
        position: 'top-end',
        toast: true,
        timer: 3500,
        timerProgressBar: true,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        },
    });
}
