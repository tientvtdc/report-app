import './bootstrap';
import "toastify-js/src/toastify.css"
import * as Popper from '@popperjs/core'

import 'bootstrap'

import Toastify from 'toastify-js'

document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.getElementById('successMessage').value;
    if (successMessage) {
        Toastify({
            text: successMessage,
            duration: 3000
        }).showToast();
    }
});
