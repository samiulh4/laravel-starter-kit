@extends('layouts.admin')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
      @include('Account::sections.nav-align-top')
      <div class="card mb-6">
        <!-- Account -->
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
            <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/avatars/1.png" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
            <div class="button-wrapper">
              <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                <span class="d-none d-sm-block">Upload new photo</span>
                <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
              </label>
              <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                <i class="icon-base bx bx-reset d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Reset</span>
              </button>

              <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
            </div>
          </div>
        </div>
        <div class="card-body pt-4">
          {{ html()->form()
            ->id('formAccountSettings')
            ->method('POST')
            ->attribute('onsubmit', 'return false')
            ->open() }}

            <div class="row g-6">
                
              <div class="col-md-6 form-control-validation">
                {{ html()->label('Name')->for('name')->class('form-label') }}
                {{ html()->input('text')
                  ->id('name')
                  ->name('name')
                  ->class('form-control')
                  ->attribute('value', $user->name)
                  ->attribute('autofocus', 'autofocus') }}
              </div>

              <div class="col-md-6 form-control-validation">
                {{ html()->label('Identity')->for('identity')->class('form-label') }}
                {{ html()->input('text')
                  ->id('identity')
                  ->name('identity')
                  ->class('form-control')
                  ->attribute('value', $user->identity)
                  ->attribute('disabled', 'disabled') }}
              </div>

              <div class="col-md-6">
                {{ html()->label('E-mail')->for('email')->class('form-label') }}
                {{ html()->input('text')
                  ->id('email')
                  ->name('email')
                  ->class('form-control')
                  ->attribute('value', $user->email)
                  ->attribute('disabled', 'disabled') }}
              </div>

              <div class="col-md-6">
                {{ html()->label('Mobile No')->for('mobile_no')->class('form-label') }}
                {{ html()->input('text')
                  ->id('mobile_no')
                  ->name('mobile_no')
                  ->class('form-control')
                  ->attribute('value', $user->mobile_no) }}
              </div>
              
              <div class="col-md-6">
                {{ html()->label('User Type')->for('user_type_code')->class('form-label') }}
                {{ html()->select('user_type_code', $userTypes, $user->user_type_code)
                  ->id('user_type_code')
                  ->class('select2 form-select')
                  ->placeholder('Select User Type')
                  ->required()
                  ->attribute('disabled', 'disabled')
                }}
              </div>

              <div class="col-md-6">
                {{ html()->label('Gender')->for('gender_code')->class('form-label') }}
                {{ html()->select('gender_code', $genders, $user->gender_code)
                  ->id('gender_code')
                  ->class('select2 form-select')
                  ->placeholder('Select Gender')
                  ->required()
                }}
              </div>

              <div class="col-md-6">
                {{ html()->label('National ID')->for('national_id')->class('form-label') }}
                {{ html()->input('text')
                  ->id('national_id')
                  ->name('national_id')
                  ->class('form-control')
                  ->attribute('value', $account->national_id ?? '') }}
              </div>

              <div class="col-md-6">
                {{ html()->label('Passport ID')->for('passport_id')->class('form-label') }}
                {{ html()->input('text')
                  ->id('passport_id')
                  ->name('passport_id')
                  ->class('form-control')
                  ->attribute('value', $account->passport_id ?? '') }}
              </div>

              <div class="col-md-6">
                {{ html()->label('Timezone')->for('timeZones')->class('form-label') }}
                {{ html()->select()
                  ->id('timeZones')
                  ->name('timeZones')
                  ->class('select2 form-select')
                  ->options([
                    '' => 'Select Timezone',
                    '-12' => '(GMT-12:00) International Date Line West',
                    '-11' => '(GMT-11:00) Midway Island, Samoa',
                    '-10' => '(GMT-10:00) Hawaii',
                    '-9' => '(GMT-09:00) Alaska',
                    '-8' => '(GMT-08:00) Pacific Time (US & Canada)',
                    '-7' => '(GMT-07:00) Arizona',
                    '-6' => '(GMT-06:00) Central Time (US & Canada)',
                    '-5' => '(GMT-05:00) Eastern Time (US & Canada)',
                    '-4' => '(GMT-04:00) Atlantic Time (Canada)'
                  ]) }}
              </div>
             
            </div>
            <div class="mt-6">
              {{ html()->button('Save changes')->type('submit')->class('btn btn-primary me-3')->id('submitAccountForm') }}
              {{ html()->button('Cancel')->type('reset')->class('btn btn-label-secondary') }}
            </div>
          {{ html()->form()->close() }}
        </div>
        <!-- /Account -->
      </div>
      <div class="card">
        <h5 class="card-header">Delete Account</h5>
        <div class="card-body">
          <div class="mb-6 col-12 mb-0">
            <div class="alert alert-warning">
              <h5 class="alert-heading mb-1">Are you sure you want to delete your account?</h5>
              <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
            </div>
          </div>
          <form id="formAccountDeactivation" onsubmit="return false">
            <div class="form-check my-8 ms-2">
              <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
              <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
            </div>
            <button type="submit" class="btn btn-danger deactivate-account" disabled>Deactivate Account</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
     <script src="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endpush

@section('script')
<script>
  document.addEventListener("DOMContentLoaded", function () {

    // ========================
    // Form Validation - Account Settings
    // ========================
    const accountSettingsForm = document.querySelector("#formAccountSettings");
    let accountValidator = null;

    if (accountSettingsForm) {
        accountValidator = FormValidation.formValidation(accountSettingsForm, {
            fields: {
                name: {
                    validators: {
                        notEmpty: { message: "Please enter name" }
                    }
                },
                email: {
                    validators: {
                        notEmpty: { message: "Please enter email" }
                    }
                },
                user_type_code: {
                    validators: {
                        notEmpty: { message: "Please select user type" }
                    }
                },
                gender_code: {
                    validators: {
                        notEmpty: { message: "Please select gender" }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: ".col-md-6, .form-control-validation"
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            },
            init: validator => {
                validator.on("plugins.message.placed", event => {
                    if (event.element && event.element.parentElement && event.element.parentElement.classList.contains("input-group")) {
                        event.element.parentElement.insertAdjacentElement("afterend", event.messageElement);
                    }
                });
            }
        });
    }


    // ========================
    // Form Validation - Account Deactivation
    // ========================
    const accountDeactivationForm = document.querySelector("#formAccountDeactivation");
    const deactivateButton = accountDeactivationForm?.querySelector(".deactivate-account");
    const accountActivationCheckbox = document.querySelector("#accountActivation");

    if (accountDeactivationForm) {
        FormValidation.formValidation(accountDeactivationForm, {
            fields: {
                accountActivation: {
                    validators: {
                        notEmpty: {
                            message: "Please confirm you want to delete account"
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: "" }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                fieldStatus: new FormValidation.plugins.FieldStatus({
                    onStatusChanged(isValid) {
                        if (deactivateButton) {
                            deactivateButton.disabled = !isValid;
                        }
                    }
                }),
                autoFocus: new FormValidation.plugins.AutoFocus()
            },
            init: validator => {
                validator.on("plugins.message.placed", event => {
                    if (event.element.parentElement.classList.contains("input-group")) {
                        event.element.parentElement.insertAdjacentElement("afterend", event.messageElement);
                    }
                });
            }
        });
    }


    // ========================
    // Account Deactivation Confirmation Popup
    // ========================
    if (deactivateButton) {
        deactivateButton.onclick = function () {
            if (accountActivationCheckbox.checked) {
                Swal.fire({
                    text: "Are you sure you would like to deactivate your account? This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete",
                    cancelButtonText: "Cancel",
                    customClass: {
                        confirmButton: "btn btn-danger me-2",
                        cancelButton: "btn btn-label-secondary"
                    },
                    buttonsStyling: false
                }).then(result => {
                    if (result.isConfirmed) {
                        // Show processing
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we delete your account',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: (toast) => {
                                Swal.showLoading()
                            }
                        });

                        // Make AJAX request to delete account
                        fetch("{{ route('admin.account.user.account.delete') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === true) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Account Deleted!",
                                    text: "Your account has been successfully deleted.",
                                    customClass: { confirmButton: "btn btn-success" },
                                    buttonsStyling: false
                                }).then(() => {
                                    // Redirect to login
                                    if (data.redirect) {
                                        window.location.href = data.redirect;
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: data.message || "Failed to delete account",
                                    customClass: { confirmButton: "btn btn-danger" },
                                    buttonsStyling: false
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: "An error occurred while deleting your account",
                                customClass: { confirmButton: "btn btn-danger" },
                                buttonsStyling: false
                            });
                        });
                    }
                });
            }
        };
    }


    // ========================
    // Mobile Number Formatting
    // ========================
    const mobileInput = document.querySelector("#mobile_no");

    if (mobileInput) {
        mobileInput.addEventListener("input", event => {
            const input = event.target.value.replace(/\D/g, "");
            if (input.length > 0) {
                mobileInput.value = formatGeneral(input, {
                    blocks: [3, 3, 4],
                    delimiters: [" ", " "]
                });
            }
        });
    }


    // ========================
    // Form Submission Handler
    // ========================
    const submitBtn = document.querySelector("#submitAccountForm");

    if (submitBtn) {
        submitBtn.onclick = function (e) {
            e.preventDefault();
            if (accountValidator) {
                // Validate the form
                accountValidator.validate().then(status => {
                    if (status === 'Valid') {
                        // Show loading
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we save your changes',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: (toast) => {
                                Swal.showLoading()
                            }
                        });

                        // Get form data
                        const formData = new FormData(accountSettingsForm);

                        // Make AJAX request
                        fetch("{{ route('admin.account.user.profile.update') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === true) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    },
                                    buttonsStyling: false
                                }).then(() => {
                                    // Optional: Reload page or update UI
                                    // window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'An error occurred',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: false
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while saving your profile',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                            });
                        });
                    }
                });
            }
        };
    }


    // ========================
    // Avatar Upload Preview
    // ========================
    const avatarImg = document.getElementById("uploadedAvatar");
    const fileInput = document.querySelector(".account-file-input");
    const resetBtn = document.querySelector(".account-image-reset");

    if (avatarImg) {
        const originalSrc = avatarImg.src;

        if (fileInput) {
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    // Show preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        avatarImg.src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    // Upload immediately
                    uploadAvatar(fileInput.files[0]);
                }
            };
        }

        if (resetBtn) {
            resetBtn.onclick = () => {
                fileInput.value = "";
                avatarImg.src = originalSrc;
            };
        }
    }

    // Function to upload avatar
    function uploadAvatar(file) {
        const formData = new FormData();
        formData.append('avatar', file);

        Swal.fire({
            title: 'Uploading...',
            text: 'Please wait while we upload your avatar',
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: (toast) => {
                Swal.showLoading()
            }
        });

        fetch("{{ route('admin.account.user.avatar.upload') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === true) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    },
                    buttonsStyling: false
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Failed to upload avatar',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while uploading avatar',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });
        });
    }

});


// ========================
// Initialize Select2
// ========================
$(function () {
    const selects = $(".select2");

    if (selects.length) {
        selects.each(function () {
            const select = $(this);
            select.wrap('<div class="position-relative"></div>');
            select.select2({ dropdownParent: select.parent() });
        });
    }
});

</script>
@endsection