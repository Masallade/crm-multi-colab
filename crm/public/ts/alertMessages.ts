declare let Swal: any; //declare Swal as a global variable in your TypeScript code so that TypeScript understands that it exists:


let displayErrorMessage = (htmlContent:any) : void => {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: htmlContent
    })
}

let displaySuccessMessage = (customMessage :string) => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: 'success',
        title: customMessage
    })
}

interface ErrorCode {
    code: number;
    message: string;
}

let isErrorCodes = (errorCode:number): boolean => {
    return laravelErrorCodes.some(error => error.code === errorCode);
}

let laravelErrorCodes : ErrorCode[] = [
    { code: 400, message: "Bad Request" },
    { code: 401, message: "Unauthorized" },
    { code: 403, message: "Forbidden" },
    { code: 404, message: "Not Found" },
    { code: 500, message: "Internal Server Error" },
];
