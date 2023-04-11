<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <nav class="navegacion" style="display: <?php if (!isset($auth)) echo "none"; ?>" }>
            <a href="index.php">Catalogo</a>
            <a href="prestamos.php">Préstamos</a>
            <a href="sanciones.php">Sanciones</a>
            <a href="miPerfil.php?codigo=<?php echo $_SESSION['codigo']; ?>">Mi Perfil</a>
        </nav>
    </div>
    <p class="copyright">Todos los derechos reservados <?php echo date("Y") . ' '; ?>&copy</p>
</footer>

</body>

</html>