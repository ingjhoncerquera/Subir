<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-dark text-white py-3">

                    <h5 class="mb-0">
                        🪑 Crear nueva mesa
                    </h5>

                </div>


                <div class="card-body p-4">

                    <?php if (!empty($_GET['error'])): ?>

                        <div class="alert alert-danger">

                            <?= htmlspecialchars(
                                $_GET['error']
                            ) ?>

                        </div>

                    <?php endif; ?>


                    <form
                        method="POST"
                        action="index.php?controller=mesa&action=guardar"
                    >

                        <div class="mb-3">

                            <label
                                for="numero"
                                class="form-label fw-bold"
                            >
                                Número de mesa
                            </label>

                            <input
                                type="number"
                                name="numero"
                                id="numero"
                                class="form-control form-control-lg"
                                min="1"
                                step="1"
                                required
                                autofocus
                                placeholder="Ejemplo: 10"
                            >

                            <div class="form-text">

                                Ingrese el número que tendrá la nueva mesa.

                            </div>

                        </div>


                        <div class="d-flex gap-2 mt-4">

                            <a
                                href="index.php?controller=mesa&action=index"
                                class="btn btn-secondary w-50"
                            >
                                ← Cancelar
                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary w-50"
                            >
                                💾 Crear mesa
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>