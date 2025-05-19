<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pare de Fumar - Seu Apoio Digital</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Pare de Fumar</h1>
            <nav id="nav-menu">
                <!-- Menu será preenchido via JavaScript dependendo do status do login -->
            </nav>
        </header>

        <main>
            <!-- Área de login -->
            <div id="login-section" class="section">
                <h2>Login</h2>
                <form id="login-form">
                    <div class="form-group">
                        <label for="username">Usuário:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Entrar</button>
                    <p>Não tem uma conta? <a href="#" id="show-register">Cadastre-se</a></p>
                </form>
            </div>

            <!-- Área de cadastro -->
            <div id="register-section" class="section" style="display: none;">
                <h2>Cadastro</h2>
                <form id="register-form">
                    <div class="form-group">
                        <label for="reg-username">Usuário:</label>
                        <input type="text" id="reg-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="reg-email">E-mail:</label>
                        <input type="email" id="reg-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="reg-password">Senha:</label>
                        <input type="password" id="reg-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="cigarettes">Cigarros por dia:</label>
                        <input type="number" id="cigarettes" name="cigarettes" required>
                    </div>
                    <div class="form-group">
                        <label for="pack-price">Preço do maço:</label>
                        <input type="number" id="pack-price" name="pack-price" step="0.01" required>
                    </div>
                    <button type="submit">Cadastrar</button>
                    <p>Já tem uma conta? <a href="#" id="show-login">Faça login</a></p>
                </form>
            </div>            <!-- Dashboard do usuário -->
            <div id="dashboard-section" class="section" style="display: none;">
                <nav class="dashboard-nav">
                    <button id="logout-btn" class="btn-secondary">Sair</button>
                </nav>
                <div class="stats-container">
                    <div class="stat-box">
                        <h3>Tempo sem fumar</h3>
                        <div id="timer" class="timer">
                            <div class="time-unit">
                                <span id="days">0</span>
                                <label>dias</label>
                            </div>
                            <div class="time-unit">
                                <span id="hours">0</span>
                                <label>horas</label>
                            </div>
                            <div class="time-unit">
                                <span id="minutes">0</span>
                                <label>min</label>
                            </div>
                            <div class="time-unit">
                                <span id="seconds">0</span>
                                <label>seg</label>
                            </div>
                        </div>
                    </div>

                    <div class="stat-box">
                        <h3>Economia</h3>
                        <div id="savings">R$ 0,00</div>
                    </div>
                </div>

                <div class="actions">
                    <button id="relapse-btn" class="danger">Registrar Recaída</button>
                </div>
            </div>
        </main>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
