<script setup>
import { onMounted } from 'vue'
import { Modal } from 'flowbite'

onMounted(() => {
    const $buttonElement = document.querySelector('#button');
    const $modalElement = document.querySelector('#modal');
    const $closeButton = document.querySelector('#closeButton');

    const modalOptions = {
        backdropClasses: 'bg-gray-900 bg-opacity-50 fixed inset-0 z-40'
    }

    if ($modalElement) {
        const modal = new Modal($modalElement, modalOptions);
        $buttonElement.addEventListener('click', () => modal.toggle());
        $closeButton.addEventListener('click', () => modal.hide());
    }
})
</script>

<template>
    <button id="button" type="button" class="text-black rounded-lg text-sm">
      He leído y Acepto el Contrato
    </button>

    <div id="modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Contenido de la Ventana Modal -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Header de la centana modal -->
                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                        Contrato | Persuasión Financial
                    </h3>
                </div>
                <!-- Cuerpo de la ventana modal -->
                <div class="p-6 space-y-6 text-base text-justify leading-relaxed text-black">

                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                        Política de Privacidad
                    </h3><br>

                    En cumplimiento con lo establecido por la Ley Federal de Transparencia y Acceso a la Información Pública Gubernamental, se informa de la política de privacidad y protección de datos personales de este sitio web. <br><br>

                    <strong>Política de privacidad y protección de datos personales:</strong> <br><br>
                        
                    Todos los datos que los usuarios ingresen en cualquier página de esta web serán utilizados sólo a efecto de consulta y no se los almacenará bajo ningún concepto en nuestros servidores, siendo imposible entonces difundirlos, distribuirlos o comercializarlos. En el mismo momento en que el usuario abandona este sitio, toda la información es completamente olvidada.
                    La información y herramientas que en este sitio se ofrecen no representa responsabilidad alguna para la administración de <a href="https://persuasion-financial.com.mx/register">https://persuasion-financial.com.mx/register.</a> <br>
                    (Soluciones Informáticas) es responsable de recabar la información necesaria para el correcto funcionamiento de los servicios que en este sitio se prestan. <br>
                    Dentro de este sitio existen vínculos y anuncios que al ser utilizados por los usuarios llevan a otros sitios de Internet propiedad de terceros. La información que el usuario llegase a proporcionar a estos sitios o los trámites que pudieran realizar allí, no se encuentra cubierta o contemplada por esta política de privacidad y su manejo o utilización no es responsabilidad de <a href="https://persuasion-financial.com.mx/register">https://persuasion-financial.com.mx/register</a>, por lo que recomendamos a nuestros usuarios verificar las políticas de privacidad aplicables a estos sitios. <br>
                    Los servicios y el contenido de este sitio web están protegidos por la Ley de Derechos de Autor y no se puede copiar, modificar, interpretar, desplegar o vender cualquier contenido que aparezca en él sin la autorización del los administradores del mismo. <br>
                    Este sitio utiliza Google AdSense para ofrecer anuncios publicitarios útiles y relevantes para el usuario. Para ello, ese sistema analiza las preferencias de nuestros usuarios, sus características demográficas, sus patrones de tráfico, y otra información en conjunto para comprender mejor quiénes constituyen nuestra audiencia y qué es lo que necesita. Al hacerlo, AdSense puede mostrarle a usted los avisos publicitarios más relevantes. A su vez, utilizamos Google Analytics para rastrear estadísticas de tráfico. Las políticas de ambas herramientas se encuentran a su disposición en <a href="https://www.google.com/intl/es_ALL/policies/privacy/">https://www.google.com/intl/es_ALL/policies/privacy/</a>. <br>
                    <a href="https://persuasion-financial.com.mx/register">https://persuasion-financial.com.mx/register</a> no tiene afiliación con ninguna institución gubernamental, es un servicio no oficial ofrecido por una entidad ajena. <br>
                    La utilización del sitio implica su lectura, comprensión y aceptación plena de todas las disposiciones incluidas en esta Política de Privacidad. Si no está de acuerdo con todas o algunas de estas condiciones le pedimos por favor que no utilice el sitio ni los servicios o información que brinda. <br>
                    Este sitio se reserva el derecho de modificar las políticas de privacidad para adaptar nuevos requerimientos legislativos, jurisprudenciales, técnicos o por cualquier otro motivo que permita brindar mejores servicios y contenidos a los usuarios sin contravenir lo establecido en la Ley de Transparencia y Acceso a la Información Pública. El uso del sitio con posterioridad al anuncio de modificaciones implicará la aceptación de las nuevas condiciones, en los mismos términos en que acepta las condiciones actuales. <br><br>

                    <strong>Publicidad personalizada:</strong><br><br>
                        
                        Los usuarios pueden desactivar la publicidad personalizada accediendo a la configuración de anuncios. Adicionalmente, puede guiar a los usuarios para que accedan al sitio web www.aboutads.info para que inhabiliten el uso de cookies publicidad personalizada de terceros.
                        Este sitio web no pertenece ni está relacionado de ninguna manera con alguna dependencia del gobierno Mexicano.
                        No se almacena ningún tipo de dato sobre Usted, todos los datos de entrada son descartados luego de su consulta. En caso de que, por razones de privacidad, Usted desee que no se muestre información de respuesta ante el ingreso de sus datos de entrada, envíe un correo a (correo) con su  c.u.r.p., r.f.c. e INE. pidiéndolo. <br><br>

                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                        Política de Cookies
                    </h3><br>

                    Utilizamos cookies de terceros para mejorar nuestros servicios y mostrarle publicidad relacionada con sus preferencias mediante el análisis de sus hábitos de navegación. <br><br>

                    <strong>¿Qué es una cookie?</strong><br><br>
                        
                    Las cookies son pequeños trozos de información que almacena el navegador en el dispositivo utilizado. Cada vez que visitas nuestro sitio web, el navegador nos envía esas cookies de para que podamos personalizar tu experiencia de acuerdo con tus intereses y preferencias. <br>
                    La mayoría de los navegadores aceptan como estándar a las cookies y permiten bloquearlas en sus ajustes de seguridad. <br><br>

                    <strong>¿Cómo desactivar las cookies de su navegador?</strong><br><br>

                    Usted podrá en cualquier momento elegir qué cookies quiere que funcionen en este sitio web configurando de forma personalizada su navegador. En los siguientes enlaces tiene información para realizar esta configuración: <br>
                    •	<a href="https://support.google.com/chrome/answer/95647?hl=es"><ins>Google Chrome</ins></a> <br>
                    •	<a href="https://support.microsoft.com/es-es/help/17442/windows-internet-explorer-delete-manage-cookies"><ins>Internet Explorer</ins></a> <br>
                    •	<a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias"><ins>Mozilla Firefox</ins></a> <br>
                    •	<a href="https://support.apple.com/es-es/HT201265"><ins>Apple Safari</ins></a> <br><br>

                    <strong>¿Qué tipo de cookies se utilizan en esta página web?</strong><br><br>

                        <strong>Cookies de análisis estadístico: </strong>Son aquellas que bien tratadas por nosotros o por terceros colaboradores, como Google Analytics, nos permiten cuantificar el número de usuarios y así realizar la medición y análisis estadístico de la utilización que hacen los usuarios del servicio ofertado. <br><br>

                        <strong>Cookies publicitarias: </strong>Son aquellas que, bien tratadas por nosotros o por terceros, como Google Adsense, nos permiten gestionar de la forma más eficaz posible la oferta de los espacios publicitarios que hay en la página web, adecuando el contenido del anuncio al contenido del servicio solicitado o al uso que realice de nuestra página web. Para ello podemos analizar sus hábitos de navegación en Internet y podemos mostrarle publicidad relacionada con su perfil de navegación. <br><br>

                        <strong>Cookies de publicidad comportamental: </strong>Son aquellas que permiten la gestión, de la forma más eficaz posible, de los espacios publicitarios que, en su caso, el editor haya incluido en una página web, aplicación o plataforma desde la que presta el servicio solicitado. Estas cookies almacenan información del comportamiento de los usuarios obtenida a través de la observación continuada de sus hábitos de navegación, lo que permite desarrollar un perfil específico para mostrar publicidad en función del mismo. <br><br>

                    <strong>¿Qué cookies se utilizan en esta página web?</strong><br><br>

                        En particular, este sitio Web utiliza Google Analytics, un servicio de análisis estadístico de webs prestado por Google, Inc. Para la prestación de estos servicios, estos utilizan cookies que recopilan la información, incluida la dirección IP del usuario, que será transmitida, tratada y almacenada por Google en los términos fijados en la Web Google.com. Incluyendo la posible transmisión de dicha información a terceros por razones de exigencia legal o cuando dichos terceros procesen la información por cuenta de Google. Lea su Política de Privacidad <a href="https://www.google.com/intl/es_ALL/policies/privacy/"><ins>aquí</ins></a> . <br>
                        Asimismo, este sitio Web utiliza Google AdSense, un servicio de publicidad web prestado por Google, Inc. Para la prestación de estos servicios, se utilizan cookies que recopilan información sobre su visita a este u otros sitios web, facilitando la visualización de anuncios relevantes de acuerdo a los sitios visitados recientemente. Lea su Política de Privacidad <a href="https://www.google.com/intl/es_ALL/policies/privacy/"><ins>aquí</ins></a> . <br>
                        Google, Inc. tiene domicilio en los Estados Unidos con sede central en 1600 Amphitheatre Parkway, Mountain View, California 94043. <br>
                        Las cookies guardadas bajo el dominio <a href="https://persuasion-financial.com.mx/register">https://persuasion-financial.com.mx/register</a> pertenecen a Google Analytics (cookies de análisis) y las cookies guardadas bajo el dominio doubleclick.net pertenecen a Google AdSense (cookies publicitarias). <br><br>

                    <strong>Aceptación de la Política de Cookies</strong><br><br>

                        Al navegar a través de esta página web, el usuario acepta de forma expresa el tratamiento de la información recabada en la forma y con los fines anteriormente mencionados. Y asimismo reconoce conocer la posibilidad de rechazar el tratamiento de tales datos o información rechazando el uso de Cookies mediante la selección de la configuración apropiada a tal fin en su navegador (esta opción de bloqueo de Cookies en su navegador le permitirá acceder a los contenidos de la web pero es posible que no a alguna de sus funcionalidades).

                </div>
                <!-- Pie de ventana modal -->
                <div class="flex justify-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button id="closeButton" type="button" class="text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>