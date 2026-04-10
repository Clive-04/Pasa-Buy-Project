<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="page-section">
    <div class="about-wrapper">
        <section class="about-intro">
            <h1>About Pasa-Buy</h1>
            <p>
                Pasa-Buy is a community-based platform that helps people request or deliver nearby items quickly and conveniently.
            </p>
            <p>
                It supports local communities by making errands easier and creating opportunities for people to help one another.
            </p>
        </section>

        <section class="team-section">
            <h2>Meet the Team</h2>

            <div class="team-grid">
                <div class="team-card">
                    <div class="team-image">
                        <img src="<?= base_url('public/img/team/reniedo.png') ?>" alt="Bea Nicole Reniedo">
                    </div>
                    <h3>Bea Nicole Reniedo</h3>
                    <span class="team-role">Project Lead</span>
                    <p>Oversees the system design and keeps the platform efficient and organized.</p>
                </div>

                <div class="team-card">
                    <div class="team-image">
                        <img src="<?= base_url('public/img/team/luce.jpg') ?>" alt="Alexa May Cy Luce">
                    </div>
                    <h3>Alexa May "Cy" Luce</h3>
                    <span class="team-role">Market & Operations Strategist</span>
                    <p>Handles market planning and helps ensure the platform meets community needs.</p>
                </div>

                <div class="team-card">
                    <div class="team-image">
                        <img src="<?= base_url('public/img/team/sales.jpg') ?>" alt="Marjhelly P. Sales">
                    </div>
                    <h3>Marjhelly P. Sales</h3>
                    <span class="team-role">User Experience & Design Specialist</span>
                    <p>Designs a simple and user-friendly interface for a smooth experience.</p>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>