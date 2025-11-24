<footer class="bg-gray-900 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            {{-- About --}}
            <div>
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-6 w-6">
                    Percy Mamani
                </h3>
                <p class="text-gray-400 text-sm">
                    Abogado y líder social comprometido con la justicia y el desarrollo de Carabaya.
                </p>
            </div>
            
            {{-- Quick Links --}}
            <div>
                <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('candidato.index') }}" class="hover:text-white transition">Sobre mí</a></li>
                    <li><a href="{{ route('noticias.index') }}" class="hover:text-white transition">Noticias</a></li>
                    <li><a href="{{ route('citas.index') }}" class="hover:text-white transition">Agendar Cita</a></li>
                    <li><a href="{{ route('contacto.index') }}" class="hover:text-white transition">Contacto</a></li>
                </ul>
            </div>
            
            {{-- Contact Info --}}
            <div>
                <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><i class="fas fa-phone mr-2"></i>+51 XXX XXX XXX</li>
                    <li><i class="fas fa-envelope mr-2"></i>contacto@percymamani.pe</li>
                    <li><i class="fas fa-map-marker-alt mr-2"></i>Carabaya, Puno</li>
                </ul>
            </div>
            
            {{-- Social Media --}}
            <div>
                <h4 class="text-lg font-semibold mb-4">Sígueme</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition text-xl">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition text-xl">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition text-xl">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Bottom Bar --}}
        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-gray-400 text-sm">
                <p>&copy; 2025 Percy Mamani. Todos los derechos reservados.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Política de Privacidad</a>
                    <a href="#" class="hover:text-white transition">Términos de Servicio</a>
                    <a href="#" class="hover:text-white transition">Aviso Legal</a>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
