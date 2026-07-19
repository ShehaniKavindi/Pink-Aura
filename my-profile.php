<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My profile — PiNK AURA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/my-profile.css">

    <link rel="icon" href="assets/images/site-images/logo.png" />
</head>

<body>

    <?php include "header.php" ?>
    <?php session_start(); 
    include "includes/connection.php";
    ?>

    <div class="wrap">
        <?php
        $rs = Database::search("SELECT * FROM `users` WHERE `email`='".$_SESSION['email']."' ");
        $num = $rs->num_rows;
        if ($num == 0) {
        ?>sign in first<?php
        } else {
            $data = $rs->fetch_assoc();
        ?>
        <div class="profile-page-head">
            <h1>My profile</h1>
            <p>Manage your personal details, shipping address, and account preferences.</p>
        </div>

        <div class="profile-layout">

            <!-- SIDEBAR -->
            <aside class="profile-sidebar">
                <div class="profile-cover"></div>

                <div class="profile-avatar-block">
                    <div class="profile-avatar">
                        <img id="avatarPreview" src="https://placehold.co/200x200/F4B9CE/4A1E30?text=AP"
                            alt="Profile picture">
                        <label class="avatar-edit-btn" for="avatarInput"
                            aria-label="Change profile picture">&#128247;</label>
                        <input type="file" id="avatarInput" accept="image/*" hidden>
                    </div>
                    <p class="profile-name"><?php echo $data['first_name']; ?> <?php echo $data['last_name']; ?></p>
                    <p class="profile-email"><?php echo $data['email']; ?></p>

                </div>

                <nav class="profile-nav" id="profileNav">
                    <button class="profile-nav-link active" data-tab="personal" type="button">
                        <span class="icon icon-pink">&#128100;</span> Personal details
                    </button>
                    <button class="profile-nav-link" data-tab="shipping" type="button">
                        <span class="icon icon-pink">&#128230;</span> Shipping details
                    </button>

                    <div class="profile-nav-divider"></div>

                    <a class="profile-nav-link" href="#">
                        <span class="icon icon-gray">&#128218;</span> My orders
                    </a>
                    <a class="profile-nav-link" href="#">
                        <span class="icon icon-gray">&#128722;</span> My bag
                    </a>
                    <a class="profile-nav-link" href="#">
                        <span class="icon icon-gray">&#9825;</span> Wishlist
                    </a>

                    <div class="profile-nav-divider"></div>

                    <button class="profile-nav-link logout" id="logoutBtn" type="button">
                        <span class="icon icon-red">&#8677;</span> Log out
                    </button>
                </nav>
            </aside>

            <!-- CONTENT -->
            <div class="profile-content">

                <!-- PERSONAL DETAILS -->
                <div class="profile-panel active" id="tab-personal">
                    <div class="profile-panel-head">
                        <div class="panel-icon">&#128100;</div>
                        <h2>Personal details</h2>
                        <div class="profile-actions" data-state="view">
                            <button class="btn outline small edit-btn" type="button">&#9998; Edit</button>
                            <button class="btn small save-btn" type="button" hidden>&#10003; Save</button>
                            <button class="btn outline small discard-btn" type="button" hidden>&#10005; Discard</button>
                        </div>
                    </div>
                    <p class="profile-panel-sub">This is how we'll address you and reach you about your orders.</p>

                    <form class="profile-form" data-form="personal">
                        <div class="form-row">
                            <div class="field">
                                <label for="firstName">First name</label>
                                <input type="text" id="firstName" value="<?php echo $data['first_name']; ?>" disabled>
                            </div>
                            <div class="field">
                                <label for="lastName">Last name</label>
                                <input type="text" id="lastName" value="<?php echo $data['last_name']; ?>" disabled>
                            </div>
                        </div>

                        <div class="field">
                            <label for="profileEmail">Email address</label>
                            <input type="email" id="profileEmail" value="<?php echo $data['email']; ?>" disabled>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <label for="phone">Phone number</label>
                                <input type="text" id="phone" value="<?php echo $data['phone']; ?>" disabled>
                            </div>
                            <div class="field" id="dobField">
                                <label for="dob">Date of birth</label>
                                <input type="date" class="date-field" id="dob" value="<?php echo $data['date_of_birth']; ?>" disabled>
                                <span class="date-display" id="dobDisplay"><?php echo $data['date_of_birth']; ?></span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- SHIPPING DETAILS -->
                <div class="profile-panel" id="tab-shipping">

                    <?php
                    $address_rs = Database::search("SELECT * FROM `addresses` WHERE `user_id`='".$data['user_id']."' ");
                    $address_num = $address_rs->num_rows;
                    if ($address_num == 0) {
                    ?>
                    <div class="profile-panel-head">
                        <div class="panel-icon">&#128230;</div>
                        <h2>Shipping details</h2>
                    </div>
                    <p class="profile-panel-sub">Where should we deliver your orders?</p>
                    <p class="profile-panel-sub" style="margin-top: 3rem;">

                    </p>

                    <?php
                    } else {
                        $address_data = $address_rs->fetch_assoc();
                    ?>
                    <div class="profile-panel-head">
                        <div class="panel-icon">&#128230;</div>
                        <h2>Shipping details</h2>
                        <div class="profile-actions" data-state="view">
                            <button class="btn outline small edit-btn" type="button">&#9998; Edit</button>
                            <button class="btn small save-btn" type="button" hidden>&#10003; Save</button>
                            <button class="btn outline small discard-btn" type="button" hidden>&#10005; Discard</button>
                        </div>
                    </div>
                    <p class="profile-panel-sub">Where should we deliver your orders?</p>

                    <form class="profile-form" data-form="shipping">
                        <div class="field">
                            <label for="addr1">Address line 1</label>
                            <input type="text" id="addr1" value="<?php echo $address_data['address_line1']; ?>" disabled>
                        </div>
                        <div class="field">
                            <label for="addr2">Address line 2 (optional)</label>
                            <input type="text" id="addr2" value="<?php echo $address_data['address_line2']; ?>" disabled>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <label for="city">City</label>
                                <input type="text" id="city" value="<?php echo $address_data['city']; ?>" disabled>
                            </div>
                            <div class="field">
                                <label for="postal">Postal code</label>
                                <input type="text" id="postal" value="<?php echo $address_data['postal_code']; ?>" disabled>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <label for="country">Country</label>
                                <input type="text" id="country" value="<?php echo $address_data['country']; ?>" disabled>
                            </div>
                            <div class="field">
                                <label for="shipPhone">Contact number</label>
                                <input type="text" id="shipPhone" value="<?php echo $address_data['contact_phone']; ?>" disabled>
                            </div>
                        </div>
                    </form>
                    <?php 
                    }
                    ?>
                </div>

            </div>
        </div>

        <?php 
        }
        ?>
    </div>

    <footer>
        <div class="logo">PiNK <span style="color:var(--color-primary-strong);">AURA</span></div>
        <div>&copy; 2026 PiNK AURA. All product photos are placeholders.</div>
    </footer>

    <script src="assets/js/wishlist.js"></script>
    <script src="assets/js/bag.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        /* ── Tab switching (Personal details / Shipping details) ── */
        const navLinks = document.querySelectorAll('.profile-nav-link[data-tab]');
        const panels = document.querySelectorAll('.profile-panel');

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');

                panels.forEach(p => p.classList.remove('active'));
                document.getElementById('tab-' + link.dataset.tab).classList.add('active');
            });
        });

        /* ── Edit / Save / Discard per form ── */
        document.querySelectorAll('.profile-panel').forEach(panel => {
            const form = panel.querySelector('.profile-form');
            if (!form) return;

            const inputs = form.querySelectorAll('input');
            const editBtn = panel.querySelector('.edit-btn');
            const saveBtn = panel.querySelector('.save-btn');
            const discardBtn = panel.querySelector('.discard-btn');
            let snapshot = {};

            function enterEditMode() {
                snapshot = {};
                inputs.forEach(input => {
                    snapshot[input.id] = input.value;
                    input.disabled = false;
                });
                editBtn.hidden = true;
                saveBtn.hidden = false;
                discardBtn.hidden = false;

                const dobField = panel.querySelector('#dobField');
                if (dobField) dobField.classList.add('editing');
            }

            function exitEditMode() {
                inputs.forEach(input => {
                    input.disabled = true;
                });
                editBtn.hidden = false;
                saveBtn.hidden = true;
                discardBtn.hidden = true;

                const dobField = panel.querySelector('#dobField');
                if (dobField) {
                    dobField.classList.remove('editing');
                    const dob = document.getElementById('dob');
                    const display = document.getElementById('dobDisplay');
                    if (dob && display && dob.value) {
                        display.textContent = new Date(dob.value + 'T00:00:00')
                            .toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            });
                    }
                }
            }

            editBtn.addEventListener('click', enterEditMode);

            discardBtn.addEventListener('click', () => {
                inputs.forEach(input => {
                    input.value = snapshot[input.id];
                });
                exitEditMode();
            });

            saveBtn.addEventListener('click', () => {
                // TODO: send updated fields to process/updateProfile.php (or shipping equivalent)
                const data = {};
                inputs.forEach(input => {
                    data[input.id] = input.value;
                });
                console.log('Saving ' + form.dataset.form + ' details:', data);
                exitEditMode();
            });
        });

        /* ── Avatar preview ── */
        document.getElementById('avatarInput').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('avatarPreview').src = e.target.result;
                // TODO: upload `file` to process/updateAvatar.php
            };
            reader.readAsDataURL(file);
        });

        /* ── Logout ── */
        document.getElementById('logoutBtn').addEventListener('click', () => {
            if (confirm('Are you sure you want to log out?')) {
                // TODO: call process/logout.php to destroy the session, then redirect
                window.location.href = 'login.html';
            }
        });
    </script>

</body>

</html>