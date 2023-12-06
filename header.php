<header>
    <span>SEA YOU SOON</span>
    <nav>
        <a class="link" href="index.php">HOME</a>
        <a class="link" href="capsule.php">CAPSULE</a>
        <a class="link" href="dock.php">DOCK</a>
        <a class="link" href="about.php">ABOUT</a>
        <?php
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                // Display a button with the username
                echo '<div class="dropdown">
                          <button onclick="toggleDropdown()" class="dropbtn link button clear-btn rounded-btn"><span><img src="assets/icons/user.svg">' . $_SESSION['user_name'] . '</span></button>
                          <div id="userDropdown" class="dropdown-content">
                              <a href="logout.php" class="button red-btn rounded-btn"><span>Logout</span></a>
                              <!-- Add other user-related options here -->
                          </div>
                      </div>';
            } else {
                // Display the login link if the user is not logged in
                echo '<a class="button sign-up-btn blue-btn rounded-btn" href="signup.php"><span>SIGN UP</span></a>';
                echo '<a class="button log-in-btn clear-btn rounded-btn" href="login.php"><span>LOGIN</span></a>';
            }
            ?>
    </nav>
</header>
<script>
// JavaScript function to toggle the dropdown

function toggleDropdown() {
    var dropdown = document.getElementById("userDropdown");
    dropdown.classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");

        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];

            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
</script>