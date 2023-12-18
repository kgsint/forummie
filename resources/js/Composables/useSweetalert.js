import Swal from "sweetalert2"
export default () => {
    const displayConfirmMessage = (text, confirmButtonText = "Delete") => {
        return Swal.fire({
            text,
            showCancelButton: true,
            confirmButtonText,
            confirmButtonColor: "#eb020e",
            denyButtonText: `Don't save`
          })
    }

    const displayToastMessage = (text) => {
        // sweetalert toast
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });
          // success toast message after delete
          Toast.fire({
              text,
              icon: "success",
          });
    }
    return {
        displayConfirmMessage,
        displayToastMessage,
    }
}
