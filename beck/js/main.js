// Elementos do DOM
const loginSection = document.getElementById('login-section');
const registerSection = document.getElementById('register-section');
const dashboardSection = document.getElementById('dashboard-section');
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const relapseBtn = document.getElementById('relapse-btn');
const logoutBtn = document.getElementById('logout-btn');

// Links de navegação
document.getElementById('show-register').addEventListener('click', (e) => {
    e.preventDefault();
    loginSection.style.display = 'none';
    registerSection.style.display = 'block';
});

document.getElementById('show-login').addEventListener('click', (e) => {
    e.preventDefault();
    registerSection.style.display = 'none';
    loginSection.style.display = 'block';
});

// Variáveis globais
let quitDate = null;
let cigarettesPerDay = 0;
let packPrice = 0;
let timerInterval = null;

// Função para iniciar o timer
function startTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    updateTimer();
    timerInterval = setInterval(updateTimer, 1000);
}

// Função para atualizar o timer
function updateTimer() {
    if (!quitDate) return;

    // Criar objeto Date a partir da string ISO
    const quit = new Date(quitDate);
    if (isNaN(quit.getTime())) {
        console.error('Data inválida:', quitDate);
        return;
    }

    // Obter a data atual
    const now = new Date();
    
    // Calcular a diferença em milissegundos
    const diff = Math.max(0, now - quit); // Evitar números negativos

    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
    
    // Atualizar elementos do DOM
    document.getElementById('days').textContent = days;
    document.getElementById('hours').textContent = hours;
    document.getElementById('minutes').textContent = minutes;
    document.getElementById('seconds').textContent = seconds;

    // Calcular economia
    const cigarettesNotSmoked = (days * cigarettesPerDay) + 
        (hours * (cigarettesPerDay / 24)) +
        (minutes * (cigarettesPerDay / 24 / 60));
    
    const packsNotBought = cigarettesNotSmoked / 5; // considerando 20 cigarros por maço
    const moneySaved = packsNotBought * packPrice;

    document.getElementById('savings').textContent = 
        `R$ ${moneySaved.toFixed(2)}`;
}

// Função para limpar o timer e os dados
function cleanup() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
    quitDate = null;
    cigarettesPerDay = 0;
    packPrice = 0;
}

// Login
loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = {
        username: document.getElementById('username').value,
        password: document.getElementById('password').value
    };

    try {
        const response = await fetch('api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
          if (data.success) {
            // A data já vem em formato ISO UTC do servidor
            quitDate = data.user.quit_date;
            cigarettesPerDay = data.user.cigarettes_per_day;
            packPrice = data.user.pack_price;
            
            loginSection.style.display = 'none';
            dashboardSection.style.display = 'block';
            
            // Iniciar o timer
            startTimer();
        } else {
            alert(data.message);
        }
    } catch (error) {
        alert('Erro ao fazer login');
    }
});

// Registro
registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = {
        username: document.getElementById('reg-username').value,
        email: document.getElementById('reg-email').value,
        password: document.getElementById('reg-password').value,
        cigarettes: parseInt(document.getElementById('cigarettes').value),
        'pack-price': parseFloat(document.getElementById('pack-price').value)
    };

    try {
        const response = await fetch('api/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        
        if (data.success) {
            alert('Cadastro realizado com sucesso! Faça login para continuar.');
            registerSection.style.display = 'none';
            loginSection.style.display = 'block';
            registerForm.reset();
        } else {
            alert(data.message);
        }
    } catch (error) {
        alert('Erro ao realizar cadastro');
    }
});

// Recaída
relapseBtn.addEventListener('click', async () => {
    if (!confirm('Tem certeza que deseja registrar uma recaída?')) {
        return;
    }

    try {
        const response = await fetch('api/relapse.php', {
            method: 'POST'
        });        const data = await response.json();
        if (data.success) {
            // Parar o timer atual
            if (timerInterval) {
                clearInterval(timerInterval);
                timerInterval = null;
            }
            
            // Atualizar a data de parada
            quitDate = data.new_quit_date;
            
            // Forçar uma atualização imediata e reiniciar o timer
            updateTimer();
            timerInterval = setInterval(updateTimer, 1000);
            
            alert('Recaída registrada. Não desista, continue tentando!');
        } else {
            alert(data.message);
        }
    } catch (error) {
        alert('Erro ao registrar recaída');
    }
});

// Logout
logoutBtn?.addEventListener('click', async () => {
    try {
        const response = await fetch('api/logout.php');
        const data = await response.json();
        
        if (data.success) {
            cleanup();
            dashboardSection.style.display = 'none';
            loginSection.style.display = 'block';
            loginForm.reset();
        }
    } catch (error) {
        alert('Erro ao fazer logout');
    }
});
