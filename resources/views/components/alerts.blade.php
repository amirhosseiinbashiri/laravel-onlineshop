  @if ($errors->any() || session('status') || session('success'))
      <div id="toast-container" class="fixed top-4 left-4 z-50 space-y-3">

          {{-- خطا --}}
          @if ($errors->any())
              <div
                  class="flex items-center justify-between bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg shadow-md animate-fade-in-down">
                  <span class="font-medium">{{ $errors->first() }}</span>
                  <button onclick="this.parentElement.remove()" class="ml-3 text-red-500 hover:text-red-700">✕</button>
              </div>
          @endif

          {{-- وضعیت --}}
          @if (session('status'))
              <div
                  class="flex items-center justify-between bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-lg shadow-md animate-fade-in-down">
                  <span class="font-medium">{{ session('status') }}</span>
                  <button onclick="this.parentElement.remove()"
                      class="ml-3 text-yellow-500 hover:text-yellow-700">✕</button>
              </div>
          @endif

          {{-- موفق --}}
          @if (session('success'))
              <div
                  class="flex items-center justify-between bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow-md animate-fade-in-down">
                  <span class="font-medium">{{ session('success') }}</span>
                  <button onclick="this.parentElement.remove()"
                      class="ml-3 text-green-500 hover:text-green-700">✕</button>
              </div>
          @endif

      </div>
  @endif

  <script>
      setTimeout(() => {
          document.querySelectorAll('#toast-container > div').forEach(el => {
              el.classList.add('opacity-0', 'translate-y-2', 'transition', 'duration-500');
              setTimeout(() => el.remove(), 500);
          });
      }, 4000);
  </script>
