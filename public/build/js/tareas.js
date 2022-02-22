!function(){!async function(){try{const t="/api/tareas?id="+i(),n=await fetch(t),o=await n.json();e=o.tareas,a()}catch(e){console.log(e)}}();let e=[],t=[];document.querySelector("#agregar-tarea").addEventListener("click",(function(){o()}));function n(n){const o=n.target.value;t=""!==o?e.filter(e=>e.estado===o):[],a()}function a(){!function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),function(){const t=e.filter(e=>"0"===e.estado),n=document.querySelector("#pendientes");0===t.length?n.disabled=!0:n.disabled=!1}(),function(){const t=e.filter(e=>"1"===e.estado),n=document.querySelector("#completadas");0===t.length?n.disabled=!0:n.disabled=!1}();const n=t.length?t:e;if(0===n.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No Hay Tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const r={0:"Pendiente",1:"Completa"};n.forEach(t=>{const n=document.createElement("LI");n.dataset.tareaId=t.id,n.classList.add("tarea");const c=document.createElement("DIV");c.classList.add("posicion");const l=document.createElement("P");l.textContent="🔼",l.ondblclick=function(t){let n=t.target.closest("ul"),a=t.target.closest("li"),o=t.target.closest("li").previousElementSibling;if(null!=o){const r=e.findIndex(e=>e.id==t.target.parentElement.parentElement.getAttribute("data-tarea-id"));let i=e[r-1];e[r-1]=e[r],e[r]=i,i=e[r-1].prioridad,e[r-1].prioridad=e[r].prioridad,e[r].prioridad=i,d(e[r],!0),d(e[r-1],!0),n.insertBefore(a,o)}};const s=document.createElement("P");s.textContent="🔽",s.ondblclick=function(t){let n=t.target.closest("ul"),a=t.target.closest("li"),o=t.target.closest("li").nextElementSibling;if(null!=o){const r=e.findIndex(e=>e.id==t.target.parentElement.parentElement.getAttribute("data-tarea-id"));let i=e[r+1];e[r+1]=e[r],e[r]=i,i=e[r+1].prioridad,e[r+1].prioridad=e[r].prioridad,e[r].prioridad=i,d(e[r],!0),d(e[r+1],!0),n.insertBefore(o,a)}},c.appendChild(l),c.appendChild(s);const u=document.createElement("P");u.textContent=t.nombre,u.ondblclick=function(){window.scrollTo({top:0,left:0,behavior:"auto"}),setTimeout(()=>{scrollTop=window.pageYOffset||document.documentElement.scrollTop,scrollLeft=window.pageXOffset||document.documentElement.scrollLeft,window.onscroll=function(){window.scrollTo(scrollLeft,scrollTop)}},0),o(editar=!0,{...t})};const m=document.createElement("DIV");m.classList.add("opciones");const p=document.createElement("BUTTON");p.classList.add("estado-tarea"),p.classList.add(""+r[t.estado].toLowerCase()),p.textContent=r[t.estado],p.dataset.estadoTarea=t.estado,p.ondblclick=function(){!function(e){const t="1"===e.estado?"0":"1";e.estado=t,d(e)}({...t})};const f=document.createElement("BUTTON");f.classList.add("eliminar-tarea"),f.dataset.idTarea=t.id,f.textContent="Eliminar",f.ondblclick=function(){!function(t){Swal.fire({title:"¿Eliminar Tarea?",showCancelButton:!0,confirmButtonText:"Si",cancelButtonText:"No"}).then(n=>{n.isConfirmed&&async function(t){const{estado:n,id:o,nombre:r}=t,d=new FormData;d.append("id",o),d.append("nombre",r),d.append("estado",n),d.append("proyectoId",i());try{const n="http://localhost:3000/api/tarea/eliminar",o=await fetch(n,{method:"POST",body:d}),r=await o.json();r.resultado&&(Swal.fire("Eliminado!",r.mensaje,"success"),e=e.filter(e=>e.id!==t.id),a())}catch(e){}}(t)})}({...t})},m.appendChild(p),m.appendChild(f),n.appendChild(c),n.appendChild(u),n.appendChild(m);document.querySelector("#listado-tareas").appendChild(n)})}function o(t=!1,n={}){const o=document.createElement("DIV");o.classList.add("modal"),o.innerHTML=`\n            <form class="formulario">\n                <legend>${t?"Editar Tarea":"Añade una nueva tarea"}</legend>\n                <div class="campo">\n                    <label>Tarea</label>\n                    <input \n                        type="text"\n                        name="tarea"\n                        placeholder="${n.nombre?"Edita la Tarea":"Añadir Tarea"}"\n                        id="tarea"\n                        value="${n.nombre?n.nombre:""}"\n                    />\n                </div>\n                <div class="contador-tarea">\n                    ${t?n.nombre.length+" / 60":"0 / 60"}\n                </div>\n                <div class="opciones">\n                    <input \n                        type="submit" \n                        class="submit-nueva-tarea" \n                        value="${n.nombre?"Guardar":"Añadir Tarea"} " \n                    />\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n            </form>\n        `,setTimeout(()=>{const e=document.querySelector(".formulario"),t=document.querySelector(".contador-tarea");document.querySelector("#tarea").addEventListener("input",(function(e){t.textContent=e.target.value.length+" / 60"})),e.classList.add("animar")},0),o.addEventListener("click",(function(l){if(l.preventDefault(),l.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{o.remove()},500),c()}if(l.target.classList.contains("submit-nueva-tarea")){const o=document.querySelector("#tarea").value.trim();if(""===o)return void r("El Nombre de la tarea es Obligatorio","error",document.querySelector(".formulario legend"));if(o.length>60)return void r("El Nombre de la tarea debe tener menos de 60 caracteres","error",document.querySelector(".formulario legend"));let l=0;for($matches=o.split(" "),$encontro=!1;l<$matches.length&&!$encontro;)/[\w]{31,}/.test($matches[l])&&($encontro=!0),l++;if($encontro)return void r("No puede haber palabras de más de 30 caracteres","error",document.querySelector(".formulario legend"));t?(n.nombre=o,d(n)):async function(t){const n=new FormData;n.append("nombre",t),n.append("prioridad",e.length+1),n.append("proyectoId",i());try{const o="http://localhost:3000/api/tarea",d=await fetch(o,{method:"POST",body:n}),i=await d.json();if(r(i.mensaje,i.tipo,document.querySelector(".filtros")),"exito"===i.tipo){document.querySelector(".modal").remove();const n={id:String(i.id),nombre:t,estado:"0",proyectoId:i.proyectoId};e=[...e,n],a()}}catch(e){console.log(e)}}(o),c()}})),document.querySelector(".dashboard").appendChild(o)}function r(e,t,n){const a=document.querySelector(".alerta");a&&a.remove();const o=document.createElement("DIV");o.classList.add("alerta",t),o.textContent=e,n.parentElement.insertBefore(o,n.nextElementSibling),setTimeout(()=>{o.remove()},5e3)}async function d(t,n=!1){const{estado:o,id:r,nombre:d,prioridad:c}=t,l=new FormData;l.append("id",r),l.append("nombre",d),l.append("estado",o),l.append("prioridad",c),l.append("proyectoId",i());try{const t="http://localhost:3000/api/tarea/actualizar",i=await fetch(t,{method:"POST",body:l}),c=await i.json();if("exito"===c.respuesta.tipo){n||Swal.fire(c.respuesta.mensaje,c.respuesta.mensaje,"success");const t=document.querySelector(".modal");t&&t.remove(),e=e.map(e=>(e.id===r&&(e.estado=o,e.nombre=d),e)),a()}}catch(e){console.log(e)}}function i(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}function c(){window.onscroll=function(){}}document.querySelectorAll('#filtros input[type="radio').forEach(e=>{e.addEventListener("input",n)})}();