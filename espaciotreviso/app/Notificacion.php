<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Notificacion extends Model {
    protected $table = 'notificacion'; protected $primaryKey = 'IDNotificacion'; public $timestamps = false;
    protected $fillable = ['IDUsuarioEmpleadoRemitente','DescripcionNotificacion','IDUsuarioEmpleadoDestinatario','IDUsuarioClienteDestinatario','CaducidadFechaNotificacion','FechaNotificacion','Atendida'];
}