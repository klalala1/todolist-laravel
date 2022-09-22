<template>
    <div>
        <b-navbar
            toggleable="lg"
            type="light"
            variant="transparent"
            fixed="top"
        >
            <!-- <b-navbar-brand href="#" style="color: black; font-weight: 700"
                >TodoList</b-navbar-brand
            > -->

            <b-navbar-toggle
                target="nav-collapse"
                style="color: black"
            ></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <!-- <b-navbar-nav>
                    <b-nav-item href="#">Link</b-nav-item>
                    <b-nav-item href="#" disabled>Disabled</b-nav-item>
                </b-navbar-nav> -->

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <!-- <b-nav-item-dropdown right>
                    
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown> -->
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
export default {
    name: "NavbarHomePage",
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.btn {
    background: linear-gradient(
        34deg,
        rgba(2, 0, 36, 1) 0%,
        rgba(121, 75, 9, 1) 0%,
        rgba(67, 41, 21, 1) 40%,
        rgba(0, 0, 0, 1) 100%
    ) !important;
    border: none !important;
}
</style>
