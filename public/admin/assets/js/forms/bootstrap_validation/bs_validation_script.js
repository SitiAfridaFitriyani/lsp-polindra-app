function snackBarAlert(message, alertBgColor) {
    Snackbar.show({
        text: message,
        actionTextColor: '#fff',
        backgroundColor: alertBgColor,
        showAction: false,
        pos: 'bottom-left',
        width: 'auto'
    });
}

(function() {
    'use strict';
    window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            var submitButton = form.querySelector('button[type="submit"]');
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            event.preventDefault();
            form.classList.add('was-validated');
            const url = form.getAttribute('action');
            const formData = $(form).serialize();
            const keyModal = $(event.target).closest('.modal').data('key-modal');

            submitButton.textContent = 'Loading...';
            submitButton.disabled = true;
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                statusCode: {
                    422: function() {
                        snackBarAlert('Error form validation', '#e7515a');
                    },
                    500: function() {
                        snackBarAlert('Internal server error', '#e7515a');
                    }
                },
                success: function(response) {
                    snackBarAlert(response.message, '#1abc9c');
                    form.reset();
                    getData();
                    $('#' + keyModal).modal('hide');
                },
                error: function(xhr, status, error) {
                    snackBarAlert('Internal server error', '#e7515a');
                },
                complete: function() {
                    submitButton.textContent = 'Simpan';
                    submitButton.disabled = false;
                }
            });
        }, false);
      });
    }, false);

    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('simple-example');
      var invalid = document.querySelector('.simple-example .invalid-feedback');
      Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            invalid.style.display = 'block';
        } else {
            invalid.style.display = 'none';
            form.classList.add('was-validated');
          }
        }, false);
      });

    }, false);

  })();
