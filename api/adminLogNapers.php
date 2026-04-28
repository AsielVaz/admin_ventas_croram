<?php
include_once __DIR__ . "/conector.php";

class AdministradorLogNapers extends Con {
    private function escape($value) {
        return addslashes(trim((string)$value));
    }

    private function filtros($fechaInicio, $fechaFin, $estatus, $buscar) {
        $where = [];

        if ($fechaInicio !== '') {
            $where[] = "fecha >= '" . $this->escape($fechaInicio) . " 00:00:00'";
        }

        if ($fechaFin !== '') {
            $where[] = "fecha <= '" . $this->escape($fechaFin) . " 23:59:59'";
        }

        if ($estatus === 'error') {
            $where[] = "mensaje LIKE 'ERROR%'";
        } elseif ($estatus === 'ok') {
            $where[] = "mensaje NOT LIKE 'ERROR%'";
        }

        if ($buscar !== '') {
            $safe = $this->escape($buscar);
            $where[] = "(mensaje LIKE '%$safe%' OR id LIKE '%$safe%')";
        }

        return $where ? 'WHERE ' . implode(' AND ', $where) : '';
    }

    public function listar($fechaInicio = '', $fechaFin = '', $estatus = '', $buscar = '', $limite = 1000) {
        $limite = max(50, min(5000, intval($limite)));
        $where = $this->filtros($fechaInicio, $fechaFin, $estatus, $buscar);
        $sql = "SELECT id, fecha, mensaje FROM log_napers $where ORDER BY id DESC LIMIT $limite";
        $datos = json_decode($this->ejecutar($sql));
        return is_array($datos) ? $datos : [];
    }

    public function resumen($fechaInicio = '', $fechaFin = '', $estatus = '', $buscar = '') {
        $where = $this->filtros($fechaInicio, $fechaFin, $estatus, $buscar);
        $sql = "SELECT 
                    COUNT(*) AS total,
                    SUM(CASE WHEN mensaje LIKE 'ERROR%' THEN 1 ELSE 0 END) AS errores,
                    SUM(CASE WHEN mensaje LIKE 'ERROR%' THEN 0 ELSE 1 END) AS exitos,
                    MIN(fecha) AS primera_fecha,
                    MAX(fecha) AS ultima_fecha
                FROM log_napers $where";
        $datos = json_decode($this->ejecutar($sql));
        return (is_array($datos) && isset($datos[0])) ? $datos[0] : (object)[
            'total' => 0,
            'errores' => 0,
            'exitos' => 0,
            'primera_fecha' => null,
            'ultima_fecha' => null
        ];
    }
}
