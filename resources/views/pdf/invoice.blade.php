<html>
<head>
  <style>
    @page { margin: 230px 50px; }
    #header { position: fixed; left: 0px; top: -230px; right: 0px; height: 250px; text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -230px; right: 0px; height: 230px; }
    #header .page:after { content: counter(page); }

  </style>
<body>
  <div id="header">
      <br/>
      <h4><center> <strong>Tabla de Retención Documental</strong></center></h4>
          <table width="100%">
            <tr><td><strong>Entidad Productora</strong></td><td>Escuela Administración Publica </td><td rowspan="2"><label class="page">Pagina </label></td>
            </tr>
            <tr><td><strong>Oficina Productora</strong></td><td>
		@foreach($orga as $o)
			{{$o->NOM_ORGA}}
		@endforeach
	    </td></tr>
          </table>
            <table border="1" cellspacing=0 cellpadding=2 >
                  
                    <tr>
                    <td width="5%" rowspan="2"><center> <strong>CODIGO</strong></center></td>
                    <td width="25%" rowspan="2"><center> <strong>SERIES Y TIPOS DOCUMENTALES</strong></center></td>
                    <td width="5%" colspan="2"><center> <strong>RETENCION</strong></center></td>
                    <td width="5%" colspan="4"><center> <strong>Disposicion Final</strong></center></td>
                    <td width="15%" rowspan="2"><center> <strong>Procedimientos</strong></center></td>
                  </tr>

                  <tr>
                    <td ><center> <strong>Archivo Gestion</td>
                    <td ><center> <strong>Archivo Central</td>
                    <td ><center> <strong>CT</td>
                    <td ><center> <strong>E</td>
                    <td ><center> <strong>M</td>
                    <td ><center> <strong>S </td>
                  </tr>
                </table>

  </div>
  <div id="footer">
    <table width="100%">
        <tr><td>Conversiones</td><td rowspan="5">Firma Responsable</td></tr>
        <tr><td>CT => Conservación Total</td></tr>
        <tr><td>E  => Eliminación</td></tr>
        <tr><td>M  => Microfilmación</td></tr>
        <tr><td>S  => Selección</td></tr>        
    </table>
  </div>
  <div id="content">
    <p>
     <table border="1" cellspacing=0 cellpadding=2>
          

        
             <tr  style="visibility:hidden;">
                    <td width="10%" rowspan="2"></td>
                    <td width="45%" rowspan="2"></td>
                    <td width="18%" colspan="2"></td>
                    <td width="12%" colspan="4"></td>
                    <td width="15%" rowspan="2"></td>
              </tr>
                 <tr style="visibility:hidden;">
                    <td ></td><td ></td><td ></td><td ></td><td ></td><td ></td>
                  </tr>

              


                      @foreach($products as $dep)
        <tr>
            <td >{{ $dep->TRD_TMP1}} </td>
            <td >{{ $dep->TRD_TMP8}} </td>
            <td >{{ $dep->TRD_TMP2}} </td>
            <td >{{ $dep->TRD_TMP3}} </td>
            <td >{{ $dep->TRD_TMP4}} </td>
            <td >{{ $dep->TRD_TMP5}} </td>
            <td >{{ $dep->TRD_TMP6}} </td>
            <td >{{ $dep->TRD_TMP7}} </td>
            <td > </td>
          </tr>

         <!-- <tr>
            <td style="width:69px;" >{{ $dep->TRD_TMP1}} </td>
            <td style="width:300px" >{{ $dep->TRD_TMP8}} </td>
             <td style="width:2.5px">{{ $dep->TRD_TMP2}} </td>
            <td style="width:2.5px">{{ $dep->TRD_TMP3}} </td>
            <td style="width:1px">{{ $dep->TRD_TMP4}} </td>
            <td style="width:1px">{{ $dep->TRD_TMP5}} </td>
            <td style="width:1px">{{ $dep->TRD_TMP6}} </td>
            <td style="width:1px">{{ $dep->TRD_TMP7}} </td>
            <td style="width:15px"></td>
          </tr>
  -->
           
         
        @endforeach
        
      </table>

    </p>
  </div>
</body>
</html>
