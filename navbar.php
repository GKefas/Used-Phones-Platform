<nav>
    <ul>
        <li class="hover-underline-animation"><a href="index.php">Home</a></li>
        <li class="search_container">
            <form>
                <input class="search__input" type="text" placeholder="  Search..." name="searchBar">
            </form>
            <a href="platform.php"><i class="fa-solid fa-magnifying-glass" id="search_icon"></i></a>
        </li>
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            echo '<li class="hover-underline-animation"><a href="con_logout.php">Logout</a></li>';
        } else {
            echo '<li class="hover-underline-animation"><a href="login_page.php">Login</a></li>';
        }
        ?>



    </ul>
</nav>