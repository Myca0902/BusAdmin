<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .step-section { display: none; }
        .step-section.active { display: block; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-dark text-white">
                    <h4>Registration</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.register.store') }}" method="POST">
                        @csrf

                        <!-- Step 1: Personal Information -->
                        <div id="step1" class="step-section active">
                            <h5 class="mb-3">Personal Information</h5>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="fname" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="lname" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Middle Name (Optional)</label>
                                <input type="text" name="middle_name" class="form-control">
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control">
                                </div>
                                <div class="col">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Select...</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="Prefer not to say">Prefer not to say</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="button" class="btn btn-primary" onclick="nextStep(2)">Continue</button>
                            </div>
                        </div>

                        <!-- Step 2: Contact Information -->
                        <div id="step2" class="step-section">
                            <h5 class="mb-3">Contact Information</h5>

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control">
                            </div>

                            
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">City/Municipality</label>
                                    <input type="text" name="city" class="form-control">
                                </div>
                                <div class="col">
                                    <label class="form-label">State/Province</label>
                                    <input type="text" name="state" class="form-control">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Street Address</label>
                                <input type="text" name="street_address" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Zip/Postal Code</label>
                                <input type="number" name="zip_code" class="form-control">
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Back</button>
                                <button type="button" class="btn btn-primary" onclick="nextStep(3)">Continue</button>
                            </div>
                        </div>

                        <!-- Step 3: Account Security -->
                        <div id="step3" class="step-section">
                            <h5 class="mb-3">Account Security</h5>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Back</button>
                                <button type="submit" class="btn btn-success">Register</button>
                            </div>
                        </div>

                    </form>

                    <!-- Already have account -->
                    <div class="text-center mt-3">
                        <p>Have an account? <a href="{{ route('admin.login') }}">Log in here</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function nextStep(step) {
        document.querySelectorAll('.step-section').forEach(s => s.classList.remove('active'));
        document.getElementById('step' + step).classList.add('active');
    }

    function prevStep(step) {
        document.querySelectorAll('.step-section').forEach(s => s.classList.remove('active'));
        document.getElementById('step' + step).classList.add('active');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
