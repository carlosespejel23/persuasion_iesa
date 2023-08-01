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
                        Contrato | Persuación
                    </h3>
                </div>
                <!-- Cuerpo de la ventana modal -->
                <div class="p-6 space-y-6">
                    <p class="text-base text-justify leading-relaxed text-black">
                      El Contrato Individual de Trabajo o Contrato Laboral, es el documento o contrato que se hace constar por escrito y no verbalmente, en el cual una persona llamada trabajador o empleado se obliga a prestar un trabajo personal subordinado a otra persona llamada patrón o empleador. Esto a cambio del pago de una determinada cantidad de dinero denominada salario que el patrón debe pagarle de manera quincenal o mensual al empleado. 
                      Es el contrato que encuentra su fundamento legal en la Ley Federal del Trabajo, en el que se establece una relación entre un empleado y un patrón. Esto con la característica de que el empleado está subordinado a un control de mando o de dirección por parte del patrón y que éste le paga al empleado un salario, además de la obligación que tiene de darlo de alta ante el Instituto Mexicano del Seguro Social.  
                      Sabías que nuestro país fue el primer país en todo el mundo en el que se le conocieron constitucionalmente los derechos y la protección a los trabajadores frente a los patrones. Esto sucedió en el año 1917, durante la promulgación de nuestra Constitución Política de los Estados Unidos Mexicanos. 
                    </p>
                </div>
                <!-- Pie de ventana modal -->
                <div class="flex justify-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button id="closeButton" type="button" class="text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>