<header>
    <style>
      /* Header Styles */
      header {
    background: linear-gradient(45deg, #4CAF50, #2196F3, #FFC107, #F44336);
    background-size: 400% 400%;
    color: #fff;
    padding: 20px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
}

.header-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
}

.header-logo {
    font-size: 24px;
    font-weight: bold;
    text-transform: uppercase;
    text-decoration: none;
    color: #fff;
}

.nav-menu {
    display: flex;
    gap: 20px;
}

.nav-menu a {
    font-size: 16px;
    text-decoration: none;
    color: #fff;
}

.mobile-menu-icon {
    display: none;
    font-size: 28px;
    cursor: pointer;
    color: #fff;
}

@media (max-width: 768px) {
    .nav-menu {
        display: none;
        flex-direction: column;
        gap: 10px;
        position: absolute;
        top: 70px;
        right: 20px;
        background: #4CAF50;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .nav-menu.show {
        display: flex;
    }

    .mobile-menu-icon {
        display: block;
    }
}

    </style>
    
    <div class="header-container">
        <nav>
            <div class="mobile-menu-icon" onclick="toggleMenu()">☰</div>
            <div class="nav-menu">
                <a href="userportfolio.php">Portfolio</a>
                <a href="userexperience.php">Experience</a>
                <a href="usercontact.php">Contact</a>
                <a href="usercollection.php">Collection</a>
                
            </div>
        </nav>
    </div>
</header>

<script>
    // JavaScript for toggling the mobile menu
    function toggleMenu() {
        const navMenu = document.querySelector('.nav-menu');
        navMenu.classList.toggle('show');
    }
</script>
