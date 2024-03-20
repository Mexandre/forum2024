<?php
if($_SESSION['niveau'] > 2) {
}
?>
<body>
    <h1>BIENVENUE DANS L'ADMINISTRATION</h1>
    <div id="containerTheme">
        <button>THEMES</button>
    </div>
    <table id="themeTable">
        <h2>THEMES</h2>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
            </tr>
        </thead>
        <tbody>
            <!-- DATA DISPLAYED DYNAMIQUEMENT -->
        </tbody>
    </table>
    <div id="containerTopic">
        <button>SUJETS</button>
    </div>
    <table id="topicTable">
        <h2>SUJETS</h2>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
            </tr>
        </thead>
        <tbody>
            <!-- DATA DISPLAYED DYNAMIQUEMENT -->
        </tbody>
    </table>
    <form id="theme-create">
        <h2>Creation de themes</h2>
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom">
        <button>Enregistré</button>
    </form>
    <div id="response"></div>
    <script src="../assets/js/forumAdmin.js"></script>
</body>
</html>
