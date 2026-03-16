<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class SolicitudEdicion extends Model {
    protected $table = 'solicitudedicion'; protected $primaryKey = 'IDSolicitud'; public $timestamps = false;
    protected $fillable = ['IDXML','IDCliente','IDEmpleado','Atendida','Observaciones','FechaCaptura','ComentariosCliente'];
}