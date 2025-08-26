<div class="form-label">
    <div class="row ms-4 mt-4">
        <div class="col-md-4 mb-3">
            <h5 class="emp-title mb-0">{{ __('Employee') }}</h5>
            <h5 class="emp-title black-text">
                {{ !empty(Workdo\Hrm\Entities\Employee::GetEmployeeByEmp($payslip->employee_id)) ? Workdo\Hrm\Entities\Employee::employeeIdFormat($payslip->employee_id) : '' }}
            </h5>
        </div>
        <div class="col-md-4 mb-3">
            <h5 class="emp-title mb-0">{{ __('Basic Salary') }}</h5>
            <h5 class="emp-title black-text">{{ currency_format($payslip->basic_salary) }}</h5>
        </div>
        <div class="col-md-4 mb-3">
            <h5 class="emp-title mb-0">{{ __('Payroll Month') }}</h5>
            <h5 class="emp-title black-text">{{ company_date_formate($payslip->salary_month) }}</h5>
        </div>
    </div>

    <div class="row px-3">
        <div class="col-lg-12 our-system">
            <form action="{{ route('payslip.updateemployee', $payslip->employee_id) }}" method="POST" id="payslipForm">
                @csrf
                <input type="hidden" name="payslip_id" value="{{ $payslip->id }}" class="form-control">
                <div class="row">
                    <div class="col-xxl-12 ">
                        <div class="card border-0">
                            <div class="card-body pt-2 favorite-templates-panel">
                                <ul class="nav nav-pills nav-fill cust-nav information-tab" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#allowance"
                                            role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Allowance') }}</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#commission"
                                        role="tab" aria-controls="pills-profile"
                                        aria-selected="false">{{ __('Commission') }}</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#loan" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">{{ __('Loan') }}</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#deduction"
                                            role="tab" aria-controls="pills-contact"
                                            aria-selected="false">{{ __('Saturation Deduction') }}</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#payment" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">{{ __('Other Payment') }}</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#overtime" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">{{ __('Overtime') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content pt-4">
                                    <div id="allowance" class="tab-pane in active">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card bg-none mb-0">
                                                    <div class="row px-3">
                                                        @php
                                                            $allowances = json_decode($payslip->allowance);
                                                        @endphp
                                                        @foreach ($allowances as $allownace)
                                                            <div class="col-md-12 form-group">
                                                                @if ($allownace->type == 'fixed')
                                                                    <label class="form-label">{{ $allownace->title }}</label>
                                                                @else
                                                                    <label class="form-label">{{ $allownace->title }} (%)</label>
                                                                @endif
                                                                <input type="text" name="allowance[]" value="{{ $allownace->amount }}" class="form-control">
                                                                <input type="hidden" name="allowance_id[]" value="{{ $allownace->id }}" class="form-control">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="commission" class="tab-pane">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card bg-none mb-0">
                                                    <div class="row px-3">
                                                        @php
                                                            $commissions = json_decode($payslip->commission);
                                                        @endphp
                                                        @foreach ($commissions as $commission)
                                                            <div class="col-md-12 form-group">
                                                                @if ($commission->type == 'fixed')
                                                                    <label class="form-label">{{ $commission->title }}</label>
                                                                @else
                                                                    <label class="form-label">{{ $commission->title }} (%)</label>
                                                                @endif
                                                                <input type="text" name="commission[]" value="{{ $commission->amount }}" class="form-control">
                                                                <input type="hidden" name="commission_id[]" value="{{ $commission->id }}" class="form-control">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="loan" class="tab-pane">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card bg-none mb-0">
                                                    <div class="row px-3">
                                                        @php
                                                            $loans = json_decode($payslip->loan);
                                                        @endphp
                                                        @foreach ($loans as $loan)
                                                            <div class="col-md-12 form-group">
                                                                @if ($loan->type == 'fixed')
                                                                    <label class="form-label">{{ $loan->title }}</label>
                                                                @else
                                                                    <label class="form-label">{{ $loan->title }} (%)</label>
                                                                @endif
                                                                <input type="text" name="loan[]" value="{{ $loan->amount }}" class="form-control">
                                                                <input type="hidden" name="loan_id[]" value="{{ $loan->id }}" class="form-control">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="deduction" class="tab-pane">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card bg-none mb-0">
                                                    <div class="row px-3">
                                                        @php
                                                            $saturation_deductions = json_decode($payslip->saturation_deduction);
                                                        @endphp
                                                        @foreach ($saturation_deductions as $deduction)
                                                            <div class="col-md-12 form-group">
                                                                @if ($deduction->type == 'fixed')
                                                                    <label class="form-label">{{ $deduction->title }}</label>
                                                                @else
                                                                    <label class="form-label">{{ $deduction->title }} (%)</label>
                                                                @endif
                                                                <input type="text" name="saturation_deductions[]" value="{{ $deduction->amount }}" class="form-control">
                                                                <input type="hidden" name="saturation_deductions_id[]" value="{{ $deduction->id }}" class="form-control">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="payment" class="tab-pane">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card bg-none mb-0">
                                                    <div class="row px-3">
                                                        @php
                                                            $other_payments = json_decode($payslip->other_payment);
                                                        @endphp
                                                        @foreach ($other_payments as $payment)
                                                            <div class="col-md-12 form-group">
                                                                @if ($payment->type == 'fixed')
                                                                    <label class="form-label">{{ $payment->title }}</label>
                                                                @else
                                                                    <label class="form-label">{{ $payment->title }} (%)</label>
                                                                @endif
                                                                <input type="text" name="other_payment[]" value="{{ $payment->amount }}" class="form-control">
                                                                <input type="hidden" name="other_payment_id[]" value="{{ $payment->id }}" class="form-control">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="overtime" class="tab-pane">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card bg-none mb-0">
                                                    <div class="row px-3">
                                                        @php
                                                            $overtimes = json_decode($payslip->overtime);
                                                        @endphp
                                                        @foreach ($overtimes as $overtime)
                                                            <div class="col-md-6 form-group">
                                                                <label class="form-label">{{ $overtime->title }} {{ __('Rate') }}</label>
                                                                <input type="text" name="rate[]" value="{{ $overtime->rate }}" class="form-control">
                                                                <input type="hidden" name="rate_id[]" value="{{ $overtime->id }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label class="form-label">{{ $overtime->title }} {{ __('Hours') }}</label>
                                                                <input type="text" name="hours[]" value="{{ $overtime->hours }}" class="form-control">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="position: relative; z-index: 100;">
                    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
                    <button type="submit" class="btn btn-primary" id="updateButton" style="position: relative; z-index: 1000;">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug log
    console.log('DOM fully loaded and parsed');
    
    // Direct removal of any potential conflicting elements
    const potentialOverlays = document.querySelectorAll('.modal-backdrop, .modal-dialog-scrollable');
    potentialOverlays.forEach(function(overlay) {
        console.log('Removing potential overlay element:', overlay);
        overlay.remove();
    });
    
    // Get form and button references
    const formElement = document.getElementById('payslipForm');
    const updateButton = document.getElementById('updateButton');
    
    console.log('Form element found:', formElement);
    console.log('Update button found:', updateButton);
    
    // Force high z-index on the button and modify pointer events
    if (updateButton) {
        updateButton.style.zIndex = '9999';
        updateButton.style.position = 'relative';
        updateButton.style.pointerEvents = 'auto';
        updateButton.style.cursor = 'pointer';
        updateButton.style.padding = '10px 20px'; // Make button bigger
        
        // Add direct onclick attribute as backup
        updateButton.setAttribute('onclick', 'this.form.submit(); return false;');
        
        // Add multiple event listeners for redundancy
        updateButton.addEventListener('click', function(e) {
            console.log('Button clicked via addEventListener');
            e.preventDefault(); // Prevent default temporarily
            setTimeout(function() {
                formElement.submit(); // Submit the form after a slight delay
            }, 10);
        });
        
        // MouseDown event as alternative
        updateButton.addEventListener('mousedown', function(e) {
            console.log('Button mousedown detected');
        });
    }
    
    // Fix potential modal issues
    const modalElement = document.querySelector('.modal');
    if (modalElement) {
        console.log('Modal found, ensuring it does not block clicks');
        modalElement.style.pointerEvents = 'auto';
    }
    
    // Add a click event to the form itself as a fallback
    if (formElement) {
        formElement.addEventListener('submit', function(e) {
            console.log('Form submit event triggered');
        });
        
        // Create a backup submit button
        const backupButton = document.createElement('button');
        backupButton.type = 'submit';
        backupButton.className = 'btn btn-success mt-2';
        backupButton.textContent = 'Alternative Update Button';
        backupButton.style.zIndex = '9999';
        backupButton.style.position = 'relative';
        backupButton.style.pointerEvents = 'auto';
        
        // Append the backup button after the modal footer
        const modalFooter = document.querySelector('.modal-footer');
        if (modalFooter) {
            modalFooter.appendChild(backupButton);
            console.log('Added backup submit button');
        }
    }
    
    // Disable any other elements that might be consuming clicks
    document.querySelectorAll('.modal, .modal-dialog, .modal-content').forEach(el => {
        el.style.pointerEvents = 'auto';
    });
    
    // Log all click events for debugging
    document.addEventListener('click', function(e) {
        console.log('Click detected on:', e.target);
    }, true); // Use capture phase
});
</script>

<style>
/* Force z-index and clickability for buttons */
.btn-primary, button[type="submit"], input[type="submit"] {
    position: relative !important;
    z-index: 9999 !important;
    pointer-events: auto !important;
    cursor: pointer !important;
}

/* Remove any pointer events blocking */
.modal-backdrop {
    display: none !important;
}

/* Ensure modal content is clickable */
.modal, .modal-dialog, .modal-content, .modal-body, .modal-footer {
    pointer-events: auto !important;
}

/* Make sure form is clickable */
form {
    position: relative !important;
    z-index: 100 !important;
}

/* Force show button */
#updateButton {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}
</style>