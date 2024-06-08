@props(['name', 'id', 'placeholder'])


<div class="flex text-3xl align-middle text-center justify-center relative">
    <x-text-input id="{{ $id }}_password" class="block mt-1 w-full"
                  type="password"
                  name="{{ $name }}"
                  placeholder="{{ $placeholder }}"
            />

    <button class="absolute right-[10px] top-[25%]" id="{{ $id }}_show-password-button" type="button">
        <i class='bx bx-show text-gray-500' id="{{ $id }}_show-password"></i>
    </button>
</div>

<script>
    let iconShowPassword_{{ $id }} = document.getElementById("{{ $id }}_show-password");
    let buttonPassword_{{ $id }} = document.getElementById("{{ $id }}_show-password-button");
    let passwordInput_{{ $id }} = document.getElementById('{{ $id }}_password')

    buttonPassword_{{ $id }}.addEventListener('click', (e) => {
        e.preventDefault();

        if(iconShowPassword_{{ $id }}.classList.contains('bx-show')) {
            iconShowPassword_{{ $id }}.classList.remove('bx-show')
            iconShowPassword_{{ $id }}.classList.add('bx-hide')
            passwordInput_{{ $id }}.type = 'text'
        }
        else {
            iconShowPassword_{{ $id }}.classList.remove('bx-hide')
            iconShowPassword_{{ $id }}.classList.add('bx-show')
            passwordInput_{{ $id }}.type = 'password'
        }
    })
</script>
