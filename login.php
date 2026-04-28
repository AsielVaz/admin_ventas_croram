<?php  session_start();?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Croram Admin · Iniciar Sesión</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --lg-primary: #2563eb;
            --lg-primary-dark: #1d4ed8;
            --lg-primary-soft: rgba(37, 99, 235, .08);
            --lg-text: #1e293b;
            --lg-text-secondary: #64748b;
            --lg-text-muted: #94a3b8;
            --lg-surface: #ffffff;
            --lg-bg: #f1f5f9;
            --lg-border: #e2e8f0;
            --lg-radius: 16px;
            --lg-radius-sm: 12px;
            --lg-shadow: 0 4px 24px rgba(0, 0, 0, .06), 0 1px 4px rgba(0, 0, 0, .04);
            --lg-shadow-lg: 0 12px 48px rgba(0, 0, 0, .1);
            --lg-font: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: var(--lg-font);
            background: var(--lg-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* ── Background pattern ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(37, 99, 235, .06) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(37, 99, 235, .04) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(148, 163, 184, .05) 0%, transparent 70%);
        }

        /* ── Subtle grid dots ── */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image: radial-gradient(circle, #cbd5e1 .75px, transparent .75px);
            background-size: 28px 28px;
            opacity: .3;
        }

        /* ── Login Card ── */
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            background: var(--lg-surface);
            border: 1px solid var(--lg-border);
            border-radius: var(--lg-radius);
            box-shadow: var(--lg-shadow);
            padding: 2.5rem 2.25rem 2rem;
            animation: cardIn .5s cubic-bezier(.4, 0, .2, 1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ── Logo area ── */
        .login-logo {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .login-logo img {
            height: 150px;
            width: auto;
            object-fit: contain;
        }

        .login-logo .logo-divider {
            width: 40px;
            height: 3px;
            background: var(--lg-primary);
            border-radius: 999px;
            margin: 1rem auto 0;
        }

        /* ── Header ── */
        .login-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .login-header h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--lg-text);
            margin-bottom: .35rem;
        }

        .login-header p {
            font-size: .88rem;
            color: var(--lg-text-secondary);
            line-height: 1.4;
        }

        /* ── Form fields ── */
        .login-field {
            margin-bottom: 1.15rem;
        }

        .login-field label {
            display: flex;
            align-items: center;
            gap: .3rem;
            font-size: .78rem;
            font-weight: 600;
            color: var(--lg-text-secondary);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: .45rem;
        }

        .login-field label .material-icons-outlined {
            font-size: .9rem;
        }

        .login-input-wrap {
            position: relative;
        }

        .login-input-wrap .material-icons-outlined.field-icon {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.15rem;
            color: var(--lg-text-muted);
            pointer-events: none;
            transition: color .2s;
        }

        .login-input-wrap input {
            width: 100%;
            padding: .7rem 1rem .7rem 2.75rem;
            border: 1.5px solid var(--lg-border);
            border-radius: var(--lg-radius-sm);
            font-family: var(--lg-font);
            font-size: .9rem;
            color: var(--lg-text);
            background: var(--lg-surface);
            transition: border-color .2s, box-shadow .2s;
        }

        .login-input-wrap input::placeholder {
            color: var(--lg-text-muted);
        }

        .login-input-wrap input:focus {
            outline: none;
            border-color: var(--lg-primary);
            box-shadow: 0 0 0 4px var(--lg-primary-soft);
        }

        .login-input-wrap input:focus~.field-icon {
            color: var(--lg-primary);
        }

        /* Eye toggle */
        .login-eye {
            position: absolute;
            right: .75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: .2rem;
            color: var(--lg-text-muted);
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            transition: color .15s;
        }

        .login-eye:hover {
            color: var(--lg-primary);
        }

        /* ── Submit button ── */
        .login-btn {
            width: 100%;
            padding: .8rem;
            margin-top: .5rem;
            border: none;
            border-radius: var(--lg-radius-sm);
            background: var(--lg-primary);
            color: #fff;
            font-family: var(--lg-font);
            font-size: .92rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            transition: background .2s, box-shadow .2s, transform .1s;
        }

        .login-btn:hover {
            background: var(--lg-primary-dark);
            box-shadow: 0 4px 16px rgba(37, 99, 235, .25);
        }

        .login-btn:active {
            transform: scale(.985);
        }

        .login-btn .material-icons-outlined {
            font-size: 1.15rem;
        }

        /* ── Footer ── */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--lg-border);
        }

        .login-footer p {
            font-size: .76rem;
            color: var(--lg-text-muted);
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .login-card {
                margin: 1rem;
                padding: 2rem 1.5rem 1.5rem;
            }
        }

        /* ── Spin animation for loading state ── */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <?php
   
    //destruir sesiones 
    $_SESSION['usuario'] = null;
    session_destroy();

    ?>

    <div class="login-card">
        <!-- Logo -->
        <div class="login-logo">
            <img src="https://grupocroram.com/adm/assets/images/logo/croram_dark_m.png" alt="Croram" />
            <div class="logo-divider"></div>
        </div>

        <!-- Header -->
        <div class="login-header">
            <h1>Bienvenido</h1>
            <p>Ingresa con tu cuenta de administrador</p>
        </div>

        <!-- Form -->
        <form id="form" novalidate>
            <div class="login-field">
                <label>
                    <span class="material-icons-outlined">person</span>
                    Usuario
                </label>
                <div class="login-input-wrap">
                    <span class="material-icons-outlined field-icon">account_circle</span>
                    <input type="text" id="txt-input" name="email" placeholder="tu@correo.com" required autocomplete="username" />
                </div>
            </div>

            <div class="login-field">
                <label>
                    <span class="material-icons-outlined">lock</span>
                    Contraseña
                </label>
                <div class="login-input-wrap">
                    <span class="material-icons-outlined field-icon">key</span>
                    <input type="password" id="pwd" name="pass" placeholder="Tu contraseña" required autocomplete="current-password" />
                    <button type="button" class="login-eye" id="eyeBtn" tabindex="-1" aria-label="Mostrar contraseña">
                        <span class="material-icons-outlined" id="eyeIcon">visibility_off</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="login-btn" id="btnLogin">
                <span class="material-icons-outlined">login</span>
                Iniciar sesión
            </button>
        </form>

        <!-- Footer -->
        <div class="login-footer">
            <p>&copy; <?php echo date('Y'); ?> Grupo Croram · Panel de Administración</p>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        /* ══ Show/hide password ══ */
        var pwShown = false;
        document.getElementById('eyeBtn').addEventListener('click', function() {
            var pwd = document.getElementById('pwd');
            var icon = document.getElementById('eyeIcon');
            pwShown = !pwShown;
            pwd.setAttribute('type', pwShown ? 'text' : 'password');
            icon.textContent = pwShown ? 'visibility' : 'visibility_off';
        });

        /* ══ Form submit (original logic) ══ */
        document.getElementById('form').addEventListener('submit', async function(e) {
            e.preventDefault();

            var btn = document.getElementById('btnLogin');
            btn.disabled = true;
            btn.innerHTML = '<span class="material-icons-outlined" style="animation:spin 1s linear infinite;">sync</span> Ingresando...';

            var formData = new FormData(this);
            formData.append('accion', 'login');

            try {
                var response = await fetch('api/apiUsuarios.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error('Error de conexión');

                var data = await response.json();

                Swal.fire({
                    title: data.mensaje || 'Resultado',
                    icon: data.tipo || 'info',
                    showConfirmButton: false,
                    timer: 1500
                });

                if (data.tipo === 'success') {
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 1500);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '<span class="material-icons-outlined">login</span> Iniciar sesión';
                }

            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo conectar con el servidor.',
                    confirmButtonColor: '#dc2626'
                });
                btn.disabled = false;
                btn.innerHTML = '<span class="material-icons-outlined">login</span> Iniciar sesión';
            }
        });
    </script>

</body>

</html>