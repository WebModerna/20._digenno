window.addEventListener("load", cargador);

function cargador()
{
	const slidersItems = document.querySelectorAll(".slider__item");
	
	for( let i = 0; i < slidersItems.length; i++ )
	{
		slidersItems[i].style.zIndex = slidersItems.length - i;
		console.log( slidersItems[i] );
	}

	// Animación de entrada y salida
	let animacionEntrada = "slideInRight",
	animacionSalida = "slideOutLeft";

	// El arreglo con cada uno de los sliders.
	const sliders = document.querySelectorAll(".animacion__carrousel");


	/* // Para inicializar los sliders ocultos
	for( let e = 0; e < sliders.length; e++ )
	{
		sliders[e].classList.add(animacionSalida);
		console.log(sliders[e]);
	} */

	// Función que se autoejecuta cada 3 segundos
	let i = 0;
	function temporizadorInfinito()
	{
		setTimeout(temporizadorInfinito, 4000);
		izq();

		// Control del contador
		i = ( i + 1 ) % sliders.length;
		der();
		console.log(sliders[i]);
	}
	temporizadorInfinito();

	// Desplazamiento hacia la izquierda y desaparece
	function izq()
	{
		sliders[i].classList.add(animacionSalida);
		sliders[i].classList.remove(animacionEntrada);
	}

	// Desplazamiento desde la derecha y se queda en el centro 
	function der()
	{
		sliders[i].classList.add(animacionEntrada);
		sliders[i].classList.remove(animacionSalida);
	}
}

