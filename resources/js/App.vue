<template>
    <div id="wrapper">
        <div class="sidebar">
            <span class="closeButton">&times;</span>
            <p class="brand-title"><a href="">Alphayo Blog</a></p>
            <div class="side-links">
                <ul>
                    <li>
                        <router-link :to="{ name: 'home'}" class="active" >Home</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'blog'}" class="active" >Blog</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'about'}" class="active" >About</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'contact'}" class="active" >Contact</router-link>
                    </li>
                </ul>
            </div>
            <!-- sidebar footer -->
            <footer class="sidebar-footer">
                <div>
                    <a href=""><i class="fab fa-facebook-f"></i></a>
                    <a href=""><i class="fab fa-instagram"></i></a>
                    <a href=""><i class="fab fa-twitter"></i></a>
                </div>

                <small>&copy; 2021 Alphayo Blog</small>
            </footer>
        </div>
        <!-- Menu Button -->
        <div class="menuButton">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <!-- main -->
        <main class="container">
            <router-view></router-view>
            <!-- Main footer -->
            <footer class="main-footer">
                <div>
                    <a href=""><i class="fab fa-facebook-f"></i></a>
                    <a href=""><i class="fab fa-instagram"></i></a>
                    <a href=""><i class="fab fa-twitter"></i></a>
                </div>
                <small>&copy; 2021 Blog</small>
            </footer>
        </main>
    </div>
</template>
