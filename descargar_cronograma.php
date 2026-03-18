<?php
header("Content-Type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; filename=Cronograma_Desarrollo_digest_lab_2026.doc");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta charset="UTF-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if gte mso 9]>
<xml>
  <w:WordDocument>
    <w:View>Print</w:View>
    <w:Zoom>90</w:Zoom>
    <w:DoNotOptimizeForBrowser/>
  </w:WordDocument>
</xml>
<![endif]-->
<style>
  @page {
    size: A4 landscape;
    margin: 2cm 1.5cm 2cm 1.5cm;
    mso-page-orientation: landscape;
  }
  body {
    font-family: Calibri, Arial, sans-serif;
    font-size: 10pt;
    color: #1a1a2e;
    line-height: 1.4;
  }
  /* ── ENCABEZADO ── */
  .titulo-doc {
    font-size: 16pt;
    font-weight: bold;
    color: #1a56db;
    text-align: center;
    margin-bottom: 2pt;
  }
  .subtitulo-doc {
    font-size: 11pt;
    color: #374151;
    text-align: center;
    margin-bottom: 12pt;
  }
  /* ── FICHA ── */
  .tbl-ficha {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 14pt;
    background: #f0f4ff;
  }
  .tbl-ficha td {
    padding: 5pt 8pt;
    font-size: 9pt;
    border: 1pt solid #c7d2fe;
  }
  .ficha-label {
    font-size: 7.5pt;
    color: #6b7280;
    text-transform: uppercase;
    display: block;
  }
  .ficha-valor {
    font-weight: bold;
    color: #1a1a2e;
  }
  /* ── SECCIÓN ── */
  .section-title {
    font-size: 12pt;
    font-weight: bold;
    color: #1a56db;
    border-bottom: 2pt solid #1a56db;
    padding-bottom: 3pt;
    margin-top: 16pt;
    margin-bottom: 8pt;
  }
  .section-subtitle {
    font-size: 9pt;
    color: #6b7280;
    margin-bottom: 8pt;
    font-style: italic;
  }
  /* ── TABLAS PRINCIPALES ── */
  .tbl-main {
    width: 100%;
    border-collapse: collapse;
    font-size: 9pt;
    margin-bottom: 8pt;
  }
  .tbl-main thead tr {
    background: #1a56db;
    color: white;
  }
  .tbl-main thead th {
    padding: 6pt 7pt;
    text-align: left;
    font-weight: bold;
    font-size: 8.5pt;
    border: 1pt solid #1343b0;
    color: white;
    mso-background-source: auto;
    background: #1a56db;
  }
  .tbl-main tbody td {
    padding: 5pt 7pt;
    border: 1pt solid #d1d5db;
    vertical-align: top;
    font-size: 9pt;
  }
  .tbl-main tbody tr:nth-child(even) td {
    background: #f8faff;
  }
  .td-center { text-align: center; }
  .td-num    { text-align: center; font-weight: bold; }
  /* ── SUBTOTAL / TOTAL ── */
  .subtotal-row td {
    background: #dbeafe;
    font-weight: bold;
    color: #1e40af;
    border: 1pt solid #93c5fd;
  }
  .total-row td {
    background: #1a56db;
    color: white;
    font-weight: bold;
    border: 1pt solid #1343b0;
  }
  /* ── BADGES CAPA ── */
  .badge-bd    { color: #92400e; font-weight: bold; }
  .badge-back  { color: #166534; font-weight: bold; }
  .badge-front { color: #1e40af; font-weight: bold; }
  .badge-integ { color: #6b21a8; font-weight: bold; }
  .badge-test  { color: #991b1b; font-weight: bold; }
  .badge-conf  { color: #9a3412; font-weight: bold; }
  /* ── PRIORIDAD ── */
  .prio-alta  { color: #dc2626; font-weight: bold; }
  .prio-media { color: #d97706; font-weight: bold; }
  /* ── RESUMEN ── */
  .tbl-resumen { width: 100%; border-collapse: collapse; margin-bottom: 14pt; }
  .tbl-resumen td, .tbl-resumen th {
    border: 1pt solid #d1d5db;
    padding: 5pt 8pt;
    text-align: center;
    font-size: 9pt;
  }
  .tbl-resumen thead tr { background: #1a56db; color: white; }
  .tbl-resumen thead th { color: white; background: #1a56db; font-weight: bold; }
  /* ── GANTT ── */
  .tbl-gantt { width: 100%; border-collapse: collapse; font-size: 8.5pt; }
  .tbl-gantt th {
    background: #1a56db;
    color: white;
    padding: 5pt 4pt;
    text-align: center;
    border: 1pt solid #1343b0;
    font-size: 8pt;
  }
  .tbl-gantt td {
    padding: 4pt 6pt;
    border: 1pt solid #d1d5db;
    font-size: 8.5pt;
  }
  .bar-f1 { background: #3b82f6; color: white; text-align: center; font-size: 7pt; }
  .bar-f2 { background: #10b981; color: white; text-align: center; font-size: 7pt; }
  .bar-f3 { background: #8b5cf6; color: white; text-align: center; font-size: 7pt; }
  .bar-f4 { background: #f59e0b; color: white; text-align: center; font-size: 7pt; }
  .bar-empty { background: #f9fafb; }
  /* ── RIESGOS ── */
  .alto  { color: #dc2626; font-weight: bold; }
  .medio { color: #d97706; font-weight: bold; }
  .bajo  { color: #16a34a; font-weight: bold; }
  /* ── FIRMA ── */
  .tbl-firma { width: 100%; border-collapse: collapse; margin-top: 30pt; }
  .tbl-firma td {
    width: 33%;
    text-align: center;
    padding: 40pt 20pt 4pt;
    border-top: 1pt solid #374151;
    vertical-align: bottom;
    font-size: 9pt;
  }
  .firma-name { font-weight: bold; }
  .firma-role { color: #6b7280; font-size: 8.5pt; }
  /* ── FOOTER ── */
  .doc-footer {
    margin-top: 12pt;
    padding-top: 6pt;
    border-top: 1pt solid #e5e7eb;
    font-size: 7.5pt;
    color: #9ca3af;
    text-align: center;
  }
  /* ── SEPARADOR ── */
  hr { border: none; border-top: 1pt solid #e5e7eb; margin: 10pt 0; }
  /* ── LISTA ── */
  ul.supuestos { padding-left: 16pt; }
  ul.supuestos li { font-size: 9pt; color: #374151; margin-bottom: 3pt; }
</style>
</head>
<body>

<!-- TÍTULO -->
<p class="titulo-doc">PLAN DE DESARROLLO DE SOFTWARE</p>
<p class="subtitulo-doc">Sistema di_gest_lab &mdash; Módulo Laboratorio Referencial &mdash; 2026</p>

<!-- FICHA -->
<table class="tbl-ficha">
  <tr>
    <td><span class="ficha-label">Código documento</span><span class="ficha-valor">PDS-LAB-2026-001</span></td>
    <td><span class="ficha-label">Versión</span><span class="ficha-valor">1.0</span></td>
    <td><span class="ficha-label">Fecha</span><span class="ficha-valor">13/03/2026</span></td>
    <td><span class="ficha-label">Estado</span><span class="ficha-valor">Aprobación pendiente</span></td>
  </tr>
  <tr>
    <td><span class="ficha-label">Proyecto</span><span class="ficha-valor">Sistema Gestión Laboratorio DIRIS</span></td>
    <td><span class="ficha-label">Elaborado por</span><span class="ficha-valor">Analista / Ing. de Sistemas</span></td>
    <td><span class="ficha-label">Inicio estimado</span><span class="ficha-valor">16/03/2026</span></td>
    <td><span class="ficha-label">Fin estimado</span><span class="ficha-valor">17/04/2026</span></td>
  </tr>
  <tr>
    <td><span class="ficha-label">Tecnología</span><span class="ficha-valor">PHP / PostgreSQL / Bootstrap 3</span></td>
    <td><span class="ficha-label">Área solicitante</span><span class="ficha-valor">Laboratorio Referencial</span></td>
    <td><span class="ficha-label">Total H/H estimadas</span><span class="ficha-valor">176 horas hombre</span></td>
    <td><span class="ficha-label">Días hábiles</span><span class="ficha-valor">~22 días hábiles</span></td>
  </tr>
</table>

<!-- RESUMEN EJECUTIVO -->
<p class="section-title">1. RESUMEN EJECUTIVO</p>
<p style="font-size:9.5pt; color:#374151; margin-bottom:10pt; line-height:1.6;">
El presente documento describe el plan de trabajo para la implementación de dos módulos funcionales en el sistema de gestión de laboratorio:
<b>(1)</b> Flujo completo para el examen <i>Hemoglobina Glicosilada (HbA1c) — Código 83036</i>, replicando la arquitectura del flujo PSA (id_producto=60) existente;
y <b>(2)</b> Módulo de mantenimiento para la gestión de <i>Grupos de Derivación por Dependencia</i>, que permitirá configurar dinámicamente qué establecimientos de origen derivan muestras a qué laboratorio de destino según convenios vigentes.
</p>

<table class="tbl-resumen">
  <thead>
    <tr>
      <th>Módulos a desarrollar</th>
      <th>Tareas totales</th>
      <th>H/H estimadas</th>
      <th>Días hábiles</th>
      <th>Semanas calendario</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="font-weight:bold;">2 módulos</td>
      <td>21 tareas</td>
      <td style="font-weight:bold;">176 h/h</td>
      <td>~22 días</td>
      <td>~4.5 semanas</td>
    </tr>
  </tbody>
</table>

<!-- MÓDULO 1 -->
<p class="section-title">2. MÓDULO 1 &mdash; Hemoglobina Glicosilada HbA1c (Código 83036)</p>
<p class="section-subtitle">Alcance: Replicar el flujo completo de PSA para el nuevo examen HbA1c con su propio id_producto y stored procedures. Comprende 15 archivos PHP nuevos/modificados + 3 objetos de BD.</p>

<table class="tbl-main">
  <thead>
    <tr>
      <th style="width:4%">#</th>
      <th style="width:33%">Tarea</th>
      <th style="width:11%">Capa</th>
      <th style="width:13%">Entregable</th>
      <th style="width:8%">Prioridad</th>
      <th style="width:8%">H/H</th>
      <th style="width:7%">Días</th>
      <th style="width:16%">Responsable</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="td-num">1.1</td>
      <td><b>Registro del producto en BD</b><br/><small>INSERT en tbl_producto para HbA1c (código 83036). Configurar componentes, valores de referencia y tipo de ingreso en tbl_componente.</small></td>
      <td class="td-center"><span class="badge-bd">[BD]</span></td>
      <td>Scripts SQL</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">6</td>
      <td class="td-num">0.75</td>
      <td>Analista BD</td>
    </tr>
    <tr>
      <td class="td-num">1.2</td>
      <td><b>Stored Procedure sp_crud_hba1c</b><br/><small>Crear en schema lab_ref. Clonar lógica de sp_crud_psa adaptando tablas e id_producto. Incluir acciones: C (crear), E (editar), D (eliminar).</small></td>
      <td class="td-center"><span class="badge-bd">[BD]</span></td>
      <td>SP PostgreSQL</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">10</td>
      <td class="td-num">1.25</td>
      <td>Analista BD</td>
    </tr>
    <tr>
      <td class="td-num">1.3</td>
      <td><b>Extensión sp_crud_envio para HbA1c</b><br/><small>Agregar acciones IREXCELHBA1C y VALIDHBA1C al SP de envío existente en schema lab.</small></td>
      <td class="td-center"><span class="badge-bd">[BD]</span></td>
      <td>SP modificado</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">6</td>
      <td class="td-num">0.75</td>
      <td>Analista BD</td>
    </tr>
    <tr>
      <td class="td-num">1.4</td>
      <td><b>Métodos en model/Lab.php</b><br/><small>Agregar get_tblDatosIngResultadoHBA1C() y get_ObtenerDatosAtencionHBA1C(). Sustituir id_producto=60 por ID de HbA1c.</small></td>
      <td class="td-center"><span class="badge-back">[Backend]</span></td>
      <td>model/Lab.php</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">4</td>
      <td class="td-num">0.5</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">1.5</td>
      <td><b>Método en model/LabRef.php</b><br/><small>Agregar post_reg_hba1c() que invoque lab_ref.sp_crud_hba1c($1,$2,$3,$4).</small></td>
      <td class="td-center"><span class="badge-back">[Backend]</span></td>
      <td>model/LabRef.php</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">2</td>
      <td class="td-num">0.25</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">1.6</td>
      <td><b>Casos en controller/ctrlLab.php</b><br/><small>Agregar: CARGA_ARCHIVO_RESUL_HBA1C, POST_ADD_RESULHBA1C, POST_ADD_VALIDRESULHBA1C, POST_ADD_VALIDRESULHBA1CUNICO. Reemplazar id_producto e id_dependencia hardcodeados.</small></td>
      <td class="td-center"><span class="badge-back">[Backend]</span></td>
      <td>ctrlLab.php</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">8</td>
      <td class="td-num">1.0</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">1.7</td>
      <td><b>Vistas: Recepción HbA1c (view/labrefen)</b><br/><small>Crear main_hba1crecepcion.php y main_hba1crecepcionn.php. Corregir referencia a id_producto hardcoded (selected="60").</small></td>
      <td class="td-center"><span class="badge-front">[Frontend]</span></td>
      <td>2 vistas PHP</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">12</td>
      <td class="td-num">1.5</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">1.8</td>
      <td><b>Vistas: Tablas clasificación (labrefen)</b><br/><small>Crear tbl_hba1crecepcionn_acep.php, tbl_hba1crecepcionn_clasi.php, tbl_hba1crecepcionn_obs.php. DataTables server-side.</small></td>
      <td class="td-center"><span class="badge-front">[Frontend]</span></td>
      <td>3 archivos PHP</td>
      <td class="prio-media">MEDIA</td>
      <td class="td-num">8</td>
      <td class="td-num">1.0</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">1.9</td>
      <td><b>Vista: Registro de Resultado HbA1c</b><br/><small>Crear main_hba1cregresultado.php + tbl_hba1cregresultado.php. Incluir carga de Excel (conversión a CSV vía libreoffice), validación individual y masiva.</small></td>
      <td class="td-center"><span class="badge-front">[Frontend]</span></td>
      <td>2 vistas PHP</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">14</td>
      <td class="td-num">1.75</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">1.10</td>
      <td><b>Vistas: Validación LAB origen (view/lab)</b><br/><small>Crear tbl_hba1crecepcionn_proceso.php y tbl_hba1crecepcionn_validado.php para seguimiento desde el establecimiento de origen.</small></td>
      <td class="td-center"><span class="badge-front">[Frontend]</span></td>
      <td>2 archivos PHP</td>
      <td class="prio-media">MEDIA</td>
      <td class="td-num">6</td>
      <td class="td-num">0.75</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">1.11</td>
      <td><b>PDFs de resultado HbA1c</b><br/><small>Crear pdf_laboratorio_hba1c.php en view/lab/ y view/labrefen/. Adaptar diseño, reemplazar firmas e imágenes. Corregir id_producto hardcoded.</small></td>
      <td class="td-center"><span class="badge-front">[Frontend]</span></td>
      <td>2 PDFs PHP</td>
      <td class="prio-media">MEDIA</td>
      <td class="td-num">8</td>
      <td class="td-num">1.0</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">1.12</td>
      <td><b>Registro en menú y asignación de accesos</b><br/><small>INSERT en tbl_menudetalle para cada vista nueva. Asignar a usuarios del LAB REFERENCIAL. Verificar rutas link_detmenu.</small></td>
      <td class="td-center"><span class="badge-conf">[Config]</span></td>
      <td>Scripts SQL</td>
      <td class="prio-media">MEDIA</td>
      <td class="td-num">3</td>
      <td class="td-num">0.5</td>
      <td>Analista</td>
    </tr>
    <tr>
      <td class="td-num">1.13</td>
      <td><b>Pruebas funcionales y correcciones</b><br/><small>Flujo completo: envío &rarr; recepción &rarr; clasificación &rarr; carga Excel &rarr; validación &rarr; PDF. Pruebas en BD test y producción.</small></td>
      <td class="td-center"><span class="badge-test">[Testing]</span></td>
      <td>Informe pruebas</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">16</td>
      <td class="td-num">2.0</td>
      <td>Analista + Dev</td>
    </tr>
    <tr class="subtotal-row">
      <td colspan="5" style="text-align:right;">SUBTOTAL MÓDULO 1 &mdash; HbA1c</td>
      <td class="td-num">103</td>
      <td class="td-num">~12.5</td>
      <td></td>
    </tr>
  </tbody>
</table>

<!-- MÓDULO 2 -->
<p class="section-title">3. MÓDULO 2 &mdash; Mantenimiento Grupos de Derivación por Dependencia</p>
<p class="section-subtitle">Alcance: Configurar dinámicamente grupos de establecimientos origen &rarr; destino para derivación de muestras según convenios vigentes. N grupos ilimitados, gestionables por el administrador del sistema.</p>

<table class="tbl-main">
  <thead>
    <tr>
      <th style="width:4%">#</th>
      <th style="width:33%">Tarea</th>
      <th style="width:11%">Capa</th>
      <th style="width:13%">Entregable</th>
      <th style="width:8%">Prioridad</th>
      <th style="width:8%">H/H</th>
      <th style="width:7%">Días</th>
      <th style="width:16%">Responsable</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="td-num">2.1</td>
      <td><b>Diseño del modelo de datos</b><br/><small>DDL para tbl_grupodependencia (id, nombre, descripcion, id_dep_destino, estado) y tbl_grupodependencia_det (id_grupodep, id_dependencia, estado). Constraint UNIQUE por grupo+dependencia. Diagrama ER.</small></td>
      <td class="td-center"><span class="badge-bd">[BD]</span></td>
      <td>DDL + Diagrama ER</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">4</td>
      <td class="td-num">0.5</td>
      <td>Analista BD</td>
    </tr>
    <tr>
      <td class="td-num">2.2</td>
      <td><b>Stored Procedure sp_crud_grupodependencia</b><br/><small>Acciones: C (crear grupo), E (editar), D (desactivar), AD (agregar dependencia origen), DD (quitar dependencia origen). Retorna estado de operación.</small></td>
      <td class="td-center"><span class="badge-bd">[BD]</span></td>
      <td>SP PostgreSQL</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">8</td>
      <td class="td-num">1.0</td>
      <td>Analista BD</td>
    </tr>
    <tr>
      <td class="td-num">2.3</td>
      <td><b>Model: GrupoDependencia.php</b><br/><small>Métodos: get_listaGrupos(), get_datoGrupoPorId(), get_dependenciasAsignadas(), get_dependenciasDisponibles(), post_reg_grupo(), post_add_dependencia(), post_del_dependencia(). Queries parametrizadas.</small></td>
      <td class="td-center"><span class="badge-back">[Backend]</span></td>
      <td>model/GrupoDependencia.php</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">5</td>
      <td class="td-num">0.75</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">2.4</td>
      <td><b>Controller: ctrlGrupoDependencia.php</b><br/><small>Switch/case: GET_LISTA_GRUPOS, GET_SHOW_DETGRUPO, GET_DEPS_ASIGNADAS, GET_DEPS_DISPONIBLES, POST_REG_GRUPO, POST_ADD_DEP, POST_DEL_DEP. Validación de sesión.</small></td>
      <td class="td-center"><span class="badge-back">[Backend]</span></td>
      <td>controller/ctrlGrupoDependencia.php</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">4</td>
      <td class="td-num">0.5</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">2.5</td>
      <td><b>Vista: Listado de Grupos (DataTable)</b><br/><small>main_grupodependencia.php con tabla: nombre grupo, establecimiento destino, nº orígenes, estado, botones gestionar/editar. Modal Bootstrap para crear/editar grupo con select de dependencia destino.</small></td>
      <td class="td-center"><span class="badge-front">[Frontend]</span></td>
      <td>Vista + Modal PHP/JS</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">10</td>
      <td class="td-num">1.25</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">2.6</td>
      <td><b>Vista: Panel Asignación Dependencias Origen</b><br/><small>Panel dual (asignadas / disponibles). Búsqueda en tiempo real por nombre. Botones Agregar/Quitar con confirmación bootbox. Indicadores de conteo por panel.</small></td>
      <td class="td-center"><span class="badge-front">[Frontend]</span></td>
      <td>Panel AJAX</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">10</td>
      <td class="td-num">1.25</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">2.7</td>
      <td><b>Integración con flujo de envío/derivación</b><br/><small>Modificar lógica de selección de destino en el flujo de envío para leer id_dep_destino desde tbl_grupodependencia según el establecimiento origen del usuario logueado en sesión.</small></td>
      <td class="td-center"><span class="badge-integ">[Integración]</span></td>
      <td>Modificación ctrlLab</td>
      <td class="prio-alta">ALTA</td>
      <td class="td-num">8</td>
      <td class="td-num">1.0</td>
      <td>Desarrollador</td>
    </tr>
    <tr>
      <td class="td-num">2.8</td>
      <td><b>Registro en menú y pruebas funcionales</b><br/><small>INSERT tbl_menudetalle en grupo Mantenimiento. Pruebas: CRUD grupos, asignación múltiple, validación convenios activos, verificar que derivación respeta configuración vigente.</small></td>
      <td class="td-center"><span class="badge-test">[Testing]</span></td>
      <td>Ítem menú + Informe</td>
      <td class="prio-media">MEDIA</td>
      <td class="td-num">8</td>
      <td class="td-num">1.0</td>
      <td>Analista + Dev</td>
    </tr>
    <tr class="subtotal-row">
      <td colspan="5" style="text-align:right;">SUBTOTAL MÓDULO 2 &mdash; Grupos Derivación</td>
      <td class="td-num">57</td>
      <td class="td-num">~7.25</td>
      <td></td>
    </tr>
  </tbody>
</table>

<!-- RESUMEN ESFUERZO -->
<p class="section-title">4. RESUMEN DE ESFUERZO</p>
<table class="tbl-main">
  <thead>
    <tr>
      <th>Módulo</th>
      <th class="td-center">Tareas</th>
      <th class="td-center">H/H Base Datos</th>
      <th class="td-center">H/H Backend</th>
      <th class="td-center">H/H Frontend</th>
      <th class="td-center">H/H Testing</th>
      <th class="td-center">TOTAL H/H</th>
      <th class="td-center">Días hábiles</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Módulo 1 &mdash; HbA1c (83036)</td>
      <td class="td-num">13</td>
      <td class="td-num">22</td>
      <td class="td-num">14</td>
      <td class="td-num">48</td>
      <td class="td-num">19</td>
      <td class="td-num"><b>103</b></td>
      <td class="td-num">~12.5</td>
    </tr>
    <tr>
      <td>Módulo 2 &mdash; Grupos Derivación</td>
      <td class="td-num">8</td>
      <td class="td-num">12</td>
      <td class="td-num">9</td>
      <td class="td-num">20</td>
      <td class="td-num">16</td>
      <td class="td-num"><b>57</b></td>
      <td class="td-num">~7.25</td>
    </tr>
    <tr>
      <td><i>Buffer contingencias (10%)</i></td>
      <td></td><td></td><td></td><td></td><td></td>
      <td class="td-num"><i>16</i></td>
      <td class="td-num"><i>~2</i></td>
    </tr>
    <tr class="total-row">
      <td>TOTAL GENERAL</td>
      <td class="td-num">21</td>
      <td class="td-num">34</td>
      <td class="td-num">23</td>
      <td class="td-num">68</td>
      <td class="td-num">35</td>
      <td class="td-num">176</td>
      <td class="td-num">~22 días</td>
    </tr>
  </tbody>
</table>

<!-- GANTT -->
<p class="section-title">5. DIAGRAMA GANTT &mdash; Distribución Semanal</p>
<p class="section-subtitle">Estimado para 1 desarrollador a 8 h/día. Inicio: lunes 16/03/2026. Fin: viernes 17/04/2026.</p>
<table class="tbl-gantt">
  <thead>
    <tr>
      <th style="width:36%; text-align:left; padding-left:8pt;">Actividad</th>
      <th style="width:13%">Sem 1<br/>16&ndash;20 Mar</th>
      <th style="width:13%">Sem 2<br/>23&ndash;27 Mar</th>
      <th style="width:13%">Sem 3<br/>30 Mar&ndash;3 Abr</th>
      <th style="width:13%">Sem 4<br/>7&ndash;11 Abr</th>
      <th style="width:12%">Sem 5<br/>14&ndash;17 Abr</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><b>1.1&ndash;1.3</b> &mdash; BD: producto + SPs HbA1c</td>
      <td class="bar-f1">&#9608;&#9608;&#9608;</td>
      <td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td>
    </tr>
    <tr>
      <td><b>1.4&ndash;1.6</b> &mdash; Backend: modelo + controlador</td>
      <td class="bar-f1">&#9608;&#9608;&#9608;</td>
      <td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td>
    </tr>
    <tr>
      <td><b>1.7&ndash;1.9</b> &mdash; Frontend: recepción + resultado</td>
      <td class="bar-empty"></td>
      <td class="bar-f2">&#9608;&#9608;&#9608;</td>
      <td class="bar-f2">&#9608;&#9608;&#9608;</td>
      <td class="bar-empty"></td><td class="bar-empty"></td>
    </tr>
    <tr>
      <td><b>1.10&ndash;1.11</b> &mdash; Frontend: validación + PDFs</td>
      <td class="bar-empty"></td><td class="bar-empty"></td>
      <td class="bar-f2">&#9608;&#9608;&#9608;</td>
      <td class="bar-empty"></td><td class="bar-empty"></td>
    </tr>
    <tr>
      <td><b>1.12&ndash;1.13</b> &mdash; Menú + Pruebas HbA1c</td>
      <td class="bar-empty"></td><td class="bar-empty"></td>
      <td class="bar-f4">&#9608;&#9608;&#9608;</td>
      <td class="bar-f4">&#9608;&#9608;&#9608;</td>
      <td class="bar-empty"></td>
    </tr>
    <tr>
      <td><b>2.1&ndash;2.2</b> &mdash; BD: tablas + SP grupos derivación</td>
      <td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td>
      <td class="bar-f3">&#9608;&#9608;&#9608;</td>
      <td class="bar-empty"></td>
    </tr>
    <tr>
      <td><b>2.3&ndash;2.4</b> &mdash; Backend: modelo + controlador grupos</td>
      <td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td>
      <td class="bar-f3">&#9608;&#9608;&#9608;</td>
      <td class="bar-empty"></td>
    </tr>
    <tr>
      <td><b>2.5&ndash;2.6</b> &mdash; Frontend: vistas grupos</td>
      <td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td>
      <td class="bar-f3">&#9608;&#9608;&#9608;</td>
      <td class="bar-f3">&#9608;&#9608;&#9608;</td>
    </tr>
    <tr>
      <td><b>2.7&ndash;2.8</b> &mdash; Integración + pruebas grupos</td>
      <td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td><td class="bar-empty"></td>
      <td class="bar-f4">&#9608;&#9608;&#9608;</td>
    </tr>
  </tbody>
</table>
<p style="font-size:8pt; color:#6b7280; margin-top:5pt;">
  <b style="color:#3b82f6;">&#9608;</b> Base de datos &nbsp;&nbsp;
  <b style="color:#10b981;">&#9608;</b> Frontend HbA1c &nbsp;&nbsp;
  <b style="color:#8b5cf6;">&#9608;</b> Módulo Grupos Derivación &nbsp;&nbsp;
  <b style="color:#f59e0b;">&#9608;</b> Pruebas / Configuración
</p>

<!-- PRE-REQUISITOS -->
<p class="section-title">6. PRE-REQUISITOS Y DEPENDENCIAS</p>
<table class="tbl-main">
  <thead>
    <tr>
      <th>Pre-requisito</th>
      <th>Responsable</th>
      <th>Estado</th>
      <th>Impacto si falta</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Definir <b>id_producto</b> para HbA1c en tbl_producto</td>
      <td>Coordinador Lab</td>
      <td class="prio-alta">PENDIENTE</td>
      <td>Bloquea tareas 1.1, 1.4, 1.6</td>
    </tr>
    <tr>
      <td>Confirmar <b>id_dependencia</b> del Lab Referencial para HbA1c (¿mismo que PSA = 67?)</td>
      <td>Coordinador Lab</td>
      <td class="prio-alta">PENDIENTE</td>
      <td>Bloquea lógica de derivación en ctrlLab</td>
    </tr>
    <tr>
      <td>Formato del archivo <b>Excel de resultados HbA1c</b> (columnas esperadas)</td>
      <td>Lab Referencial</td>
      <td class="prio-alta">PENDIENTE</td>
      <td>Bloquea tarea 1.9 (carga de archivo)</td>
    </tr>
    <tr>
      <td>Firmas digitales / imágenes para PDF HbA1c</td>
      <td>Lab Referencial</td>
      <td class="prio-media">PENDIENTE</td>
      <td>Solo estético, no bloquea flujo funcional</td>
    </tr>
    <tr>
      <td>Reglas de negocio grupos derivación (¿un establecimiento puede pertenecer a 2 grupos?)</td>
      <td>Jefatura DIRIS</td>
      <td class="prio-alta">PENDIENTE</td>
      <td>Impacta diseño de BD tarea 2.1</td>
    </tr>
    <tr>
      <td>Acceso a servidor de producción para despliegue final</td>
      <td>TI / Infraestructura</td>
      <td class="bajo">OK</td>
      <td>&mdash;</td>
    </tr>
  </tbody>
</table>

<!-- RIESGOS -->
<p class="section-title">7. GESTIÓN DE RIESGOS</p>
<table class="tbl-main">
  <thead>
    <tr>
      <th style="width:30%">Riesgo identificado</th>
      <th style="width:12%">Probabilidad</th>
      <th style="width:10%">Impacto</th>
      <th>Plan de mitigación</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Formato Excel HbA1c diferente al de PSA</td>
      <td class="alto">Alta</td><td class="alto">Alto</td>
      <td>Solicitar muestra del archivo antes de iniciar tarea 1.9. Diseñar parser configurable por columnas.</td>
    </tr>
    <tr>
      <td>Desarrollo de stored procedures tarda más de lo estimado</td>
      <td class="medio">Media</td><td class="medio">Medio</td>
      <td>Iniciar BD en paralelo con análisis. Usar el buffer del 10% para absorber desfase.</td>
    </tr>
    <tr>
      <td>OPcache en producción no refresca automáticamente tras deploy</td>
      <td class="alto">Alta</td><td class="medio">Medio</td>
      <td>Crear script opcache_reset.php para cada despliegue. Reiniciar Apache post-deploy.</td>
    </tr>
    <tr>
      <td>Columnas ambiguas en nuevos JOINs (error PostgreSQL)</td>
      <td class="medio">Media</td><td class="medio">Medio</td>
      <td>Calificar siempre con alias de tabla en todas las consultas nuevas. Code review antes de pruebas.</td>
    </tr>
    <tr>
      <td>Requisitos de grupos de derivación cambian durante desarrollo</td>
      <td class="medio">Media</td><td class="alto">Alto</td>
      <td>Validar diseño de BD con jefatura antes de codificar. Tarea 2.1 es puerta de entrada obligatoria.</td>
    </tr>
    <tr>
      <td>Retrasos por falta de información (IDs, firmas, formatos)</td>
      <td class="alto">Alta</td><td class="medio">Medio</td>
      <td>Levantar pre-requisitos en la primera semana en paralelo con tareas de BD. No iniciar vistas sin IDs confirmados.</td>
    </tr>
  </tbody>
</table>

<!-- SUPUESTOS -->
<p class="section-title">8. SUPUESTOS Y RESTRICCIONES</p>
<ul class="supuestos">
  <li>Se dispone de <b>1 desarrollador full-stack</b> dedicado al proyecto con conocimiento del sistema existente.</li>
  <li>El servidor de desarrollo local usa XAMPP con PHP &ge; 7.4 y PostgreSQL &ge; 12.</li>
  <li>El entorno de producción tiene la misma versión de PHP y PostgreSQL que el entorno de desarrollo.</li>
  <li>Las estimaciones de horas no incluyen capacitación al usuario final ni elaboración de manuales de usuario.</li>
  <li>El flujo de HbA1c es <b>idéntico en lógica</b> al de PSA &mdash; solo cambian: id_producto, estructura del Excel de resultados y firmas del PDF.</li>
  <li>No se requieren cambios en el sistema de autenticación ni en la gestión de sesiones actual.</li>
  <li>El <i>buffer del 10%</i> cubre: correcciones de bugs en etapa de pruebas, ajustes de interfaz y coordinación interna.</li>
  <li>Los despliegues a producción se realizan mediante <b>git pull</b> desde el repositorio configurado, complementado con script de reset de OPcache.</li>
</ul>

<!-- FIRMA -->
<table class="tbl-firma">
  <tr>
    <td>
      <span class="firma-name">Elaborado por</span><br/>
      <span class="firma-role">Analista de Sistemas</span>
    </td>
    <td>
      <span class="firma-name">Revisado por</span><br/>
      <span class="firma-role">Jefe de TI / Coordinador</span>
    </td>
    <td>
      <span class="firma-name">Aprobado por</span><br/>
      <span class="firma-role">Dirección / Jefatura DIRIS</span>
    </td>
  </tr>
</table>

<div class="doc-footer">
  PDS-LAB-2026-001 v1.0 &mdash; CONFIDENCIAL USO INTERNO &mdash; Sistema di_gest_lab &mdash; DIRIS Lima Centro &mdash; Marzo 2026
</div>

</body>
</html>
