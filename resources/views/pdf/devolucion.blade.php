<html>
<head>
  <style>
    @page { margin: 150px 50px; }
    #header { position: fixed; left: 0px; top: -100px; right: 0px; height: 150px; }
    #footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 15  0px; }
    #header .page:after { content: counter(page); }

  

  body {
    font: 80% sans-serif;
  }

  </style>

<body>
  <div id="header">
    <table width="100%">
      <tr>
        <td style="text-align: left;     font-size: 60%;"> 
          Proceso: Devolución de documentos recibidos en préstamo
        </td>
        <td style="text-align: right;     font-size: 60%;">
          Version: 1.0
        </td>
      </tr>
    </table>


    <table width="100%">
      <tr>
        <td rowspan="4" width="15%"> </td>
        <td rowspan="4" width="70%">
          <table width="100%">
            <tr>
              <td><strong>CONVENIO INTERADMINISTRATIVO 183-2017 SAP-TELEBUCARAMANGA</strong></td>
            </tr>
            <tr>
              <td><strong>Formato 002: Recolección de Documentos</strong></td>
            </tr>
          </table>
        </td>
        <td rowspan="4" width="15%"><p>&nbsp;</p></td>
      </tr>
      <tr>
       
      </tr>
    </table>   
  </div>
  <div id="footer">


  </div>
  <div id="content">
      <table width="100%" border="1" cellspacing=0 cellpadding=2 >
        <tr>
          <td width="50%" style="background:#c4c4c4"><strong>FECHA</strong></td>
          <td width="50%">{{$prestamo->FEC_DEVOL}}</td>
          <td width="50%" style="background:#c4c4c4"><strong>No</strong></td>
          <td width="50%">{{$prestamo->SID_PRES}}<</td>
        </tr>
         <tr>
          <td colspan="2" style="background:#c4c4c4"><strong>OFICINA SOLICITANTE</strong></td>
          <td colspan="2">{{$prestamo->SID_OFCI}}</td>
        </tr>
        <tr>
          <td colspan="2" style="background:#c4c4c4"><strong>FUNCIONARIO QUIEN SOLICITA</strong></td>
          <td colspan="2">{{$prestamo->NOM_SOLI}}</td>
        </tr>
      </table>

    
           
      <p>&nbsp;</p>

      <table width="100%" border="1" cellspacing=0 cellpadding=2 >
        <tr>
          <td colspan="1" style="background:#c4c4c4"><strong>SOPORTE</strong></td>
          <td colspan="3">{{$prestamo->DES_SOPO}}</td>
        </tr>
      </table>

    <br/>
    <table width="100%" border="1" cellspacing=0 cellpadding=2 >
      <thead>
        <tr>
          <th style="background:#c4c4c4"><strong>ITEM</strong></th>
          <th style="background:#c4c4c4"><strong>CAJA</strong></th>
          <th style="background:#c4c4c4"><strong>CARPETA</strong></th>
          <th style="background:#c4c4c4"><strong>TIPO</strong></th>
          <th style="background:#c4c4c4"><strong>OBSERVACION</strong></th>
          <th style="background:#c4c4c4"><strong>FECHA DE SOLICITUD</strong></th>
        </tr>
      </thead>
      
      @if($recorrer != null)
      <?php $i=1 ?>
       @foreach ($recorrer as $key)
          <tr> 
            <td>{{$i++}}</td>
            <td>{{$key->SID_CAJA}}</td>
            <td>{{$key->SID_CARP}}</td>
            <td>{{$key->SID_TIPO}}</td>
            <td>{{$key->SID_OBSE}}</td>
            <td>{{$key->FEC_SOLI}}</td>
          </tr>
        @endforeach

      @endif
    </table>

  </div>
</body>
</html>
