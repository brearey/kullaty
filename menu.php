<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="index.php">
            <img src="images/180x180.png" alt="Логотип Куллаты" height="50">
        </a>
        <span class="navbar-brand" id="title" style="font-size: 1.3rem;">сайт</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto" style="font-size: 1.1rem;">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-tint text-primary"></i>  Заказать воду</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reference.php"><i class="far fa-question-circle"></i>  Справка</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orderStatus.php"><i class="fas fa-info-circle"></i>  Статус заказа</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="homeshortcut.php"><i class="fas fa-link"></i> Значок на главный экран</a>
                </li>
            </ul>
        </div>
    </nav>
    <script>
        var spanTitle = document.getElementById('title');
        var title = document.getElementsByTagName('title')[0];
        spanTitle.textContent = title.textContent;
    </script>