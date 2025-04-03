<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="login.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("images/regi.jpg");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .input-field1 {
            width: 100%;
            height: 55px;
            font-size: 16px;
            background: transparent;
            color: white;
            padding-inline: 20px 50px;
            border: 2px solid var(--primary-color);
            border-radius: 30px;
            outline: none;
        }

        option {
            background-color: black !important;
            color: white !important;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="login_box">
            <div class="login-header">
                <span>Register</span>
            </div>
            <form id="registerForm" action="register_process.php" method="POST">
                <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : ''; ?>">
                <div class="input_box">
                    <input type="text" id="username" class="input-field" name="username" autocomplete="username">
                    <label for="username" class="label">Username</label>
                    <i class="bx bx-user icon"></i>
                </div>
                <div class="input_box">
                    <input type="email" id="email" class="input-field" name="email">
                    <label for="email" class="label">Email</label>
                    <i class="bx bx-user icon"></i>
                </div>
                <div class="input_box">
                    <input type="password" id="pass" class="input-field" name="password" autocomplete="current-password">
                    <label for="password" class="label">Password</label>
                    <i class="bx bx-lock-alt icon"></i>
                </div>
                <div class="input_box">
                    <input type="text" name="phone" id="phone" class="input-field" required>
                    <label for="phone" class="label">Phone Number</label>
                </div>
                <div class="input_box">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="input-field">
                </div>
                <div class="input_box">
                    <label for="state">State</label>
                    <select name="state" id="state" class="input-field1" required>
                        <option value="">Select State</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="West Bengal">West Bengal</option>
                        <option value="Goa">Goa</option>
                    </select>
                </div>
                <div class="input_box">
                    <label for="preferred_destination">Preferred Travel Destination</label>
                    <select name="preferred_destination" id="preferred_destination" class="input-field1" required>
                        <option value="">Select Destination</option>
                        <option value="Beaches">Beaches</option>
                        <option value="Mountains">Mountains</option>
                        <option value="Heritage Sites">Heritage Sites</option>
                        <option value="Wildlife Sanctuaries">Wildlife Sanctuaries</option>
                        <option value="Hill Stations">Hill Stations</option>
                    </select>
                </div>
                <div class="input_box">
                    <textarea name="address" id="address" class="input-field" required></textarea>
                    <label for="address" class="label">Address</label>
                </div>
                <div class="input_box">
                    <input type="text" name="emergency_contact" id="emergency_contact" class="input-field" required>
                    <label for="emergency_contact" class="label">Emergency Contact</label>
                </div>
                <div class="input_box">
                    <input type="file" name="profile_picture" id="profile_picture" class="input-field">
                    <label for="profile_picture" class="label">Profile Picture</label>
                </div>
                <div class="input_box">
                    <input type="submit" class="input-submit" value="Register">
                </div>

                <div class="register">
                    <span>Already have an account?<a href="login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Login</a></span>
                </div>
            </form>
        </div>
    </div>
</body>

</html>