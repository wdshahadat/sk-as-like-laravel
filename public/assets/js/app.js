function upFirst(str) {
    return str
        ? str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
              return letter.toUpperCase();
          })
        : str;
}

function modalErrorMessage(error) {
    if (error.response) {
        let errorData = "";
        const errors = error.response.data;
        for (let err in errors) {
            let error =
                typeof errors[err] === "object" && errors[err] !== null
                    ? errors[err][Object.keys(errors[err])[0]]
                    : errors[err];
            errorData += `<p><strong>${upFirst(
                err.split("_")[0]
            )}: </strong> ${error.toString()}</p>`;
        }

        if (typeof afterErrorRunFn === "function") {
            afterErrorRunFn.call(error.response);
        }

        let errorContainer = $("#errors");
        if (errorContainer[0]) {
            errorContainer.html(errorData);
            $("#alert_identifier").slideDown();
            setTimeout(function () {
                $("#alert_identifier").slideUp();
            }, 3500);
        } else {
            return alertMessage({
                error: errorData,
            });
        }
    }
}

function alertMessage(message) {
    if (message) {
        const type = Object.keys(message)[0];
        if (type === "error" && typeof message[type] === "object") {
            return modalErrorMessage({ response: { data: message[type] } });
        }
        switch (type) {
            case "info":
                toastr.info(message[type]);
                break;
            case "success":
                toastr.success(message[type]);
                break;
            case "warning":
                toastr.warning(message[type]);
                break;
            case "error":
                toastr.error(message[type]);
                break;
        }
    }
}
