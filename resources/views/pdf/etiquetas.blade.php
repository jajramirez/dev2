<html>
<head>
  <style>
    @page {    margin-top: 4em;
            margin-left: 1em; }

  body {
    font: 80% sans-serif;
  }

  </style>

<body>

    @foreach($fuid as $f)

     <table width="100%" border="1" cellspacing=0 cellpadding=2 >
         <tr style="page-break-after: always;">
          <td rowspan="4" colspan="2"></td>
          <td colspan="4"><center>
            <strong>ESCUELA SUPERIOR DE EDUCACIÓN PUBLICA - ESAP</strong></center>
          </td>
        </tr>
          <tr style="page-break-after: always;">
           <td colspan="4"><center><strong>Secretaria General</strong></center></td>
        </tr>
         <tr style="page-break-after: always;">
          <td colspan="4"><center><strong>ROTULO INDENTIFICAIÓN CARPETAS</strong></center></td>
        </tr>
         <tr style="page-break-after: always;">
           <td><strong>Version: </strong></td>
           <td><strong>Fecha: {{$FEC_ACTU}}</strong></td>
           <td><strong>Pagina </strong></td>
           <td><strong>Codigo</strong></td>
        </tr>



        <tr style="page-break-after: always;">
          <td colspan="6"> UNIDAD PRODUCTORA: {{$f->NOM_ORGA}}</td>
        </tr>
        <tr>
          <td colspan="6">SERIE: {{$f->NOM_SERI}}</td>
        <tr style="page-break-after: always;">
          <td colspan="6">SUBSERIE: {{$f->NOM_SUBS}}</td>
         </tr>
          <tr style="page-break-after: always;">
          <td colspan="6">DETALLE: {{$f->NOM_ASUN}}</td>
         </tr>
          <tr style="page-break-after: always;">
           <td colspan="6"><br/></td>
        </tr>
         <tr style="page-break-after: always;">
          <td colspan="6">FECHAS EXTREMAS</td>
        </tr>
          <tr style="page-break-after: always;">
            <td colspan="3"><center>INICIAL</center></td>
            <td colspan="3"><center>FINAL</center></td>
        </tr>



         <tr style="page-break-after: always;">
            <td><center>Año</center></td>
            <td><center>Mes</center></td>
            <td><center>Dia</center></td>
            <td><center>Año</center></td>
            <td><center>Mes</center></td>
            <td><center>Dia</center></td>
        </tr>
        <tr style="page-break-after: always;">
            <td><center><?php echo substr($f->FEC_INIC,0,4) ?></center></td>
            <td><center><?php echo substr($f->FEC_INIC,5,2) ?></center></td>
            <td><center><?php echo substr($f->FEC_INIC,8,10) ?></center></td>
            <td><center><?php echo substr($f->FEC_FINA,0,4) ?></center></td>
            <td><center><?php echo substr($f->FEC_FINA,5,2) ?></center></td>
            <td><center><?php echo substr($f->FEC_FINA,8,10) ?></center></td>
        </tr>
             <tr style="page-break-after: always;">
            <td><center>AAAA</center></td>
            <td><center>MM</center></td>
            <td><center>DD</center></td>
            <td><center>AAAA</center></td>
            <td><center>MM</center></td>
            <td><center>DD</center></td>
        </tr>
        <tr style="page-break-after: always;">
            <td><center><br/></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
        </tr>
         <tr style="page-break-after: always;">
          <td colspan="3">Numero Folios: {{$f->NUM_FOLI}}</td>
          <td colspan="3">Tomo No. {{$f->NUM_TOMO}}</td>
        </tr>

         <tr style="page-break-after: always;">
           <td colspan="6"><br/></td>
        </tr>


         <tr style="page-break-after: always;">
           <td colspan="6"><center>ARCHIVO CENTRAL</center></td>
        </tr>
        <tr style="page-break-after: always;">
            <td colspan="3">CARPETA No. {{$f->NUM_CARP}}</td>
            <td colspan="3">CAJA.{{$f->NUM_CAJA}}</td>
        </tr>
         <tr style="page-break-after: always;">
            <td colspan="3">ESTANTE</td>
            <td colspan="3">DEPOSITO</td>
        </tr>

      </table>

      <br/>
      <br/>
      <br/>
    @endforeach
</body>
</html>
