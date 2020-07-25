<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Hash;
use \App\User;
use \App\Models\Post;

class UserTest extends TestCase
{
	use RefreshDatabase;

	/**     
	 * Test de creación de usuario
	 * 
	 * @test
	 */
	public function add_user()
	{
		// Se indica que la cantidad inicial es de 0 registros de usuarios
		$this->assertEquals(0, User::count());

		// Ejecuto la acción a testear, en este caso la creación de un usuario
		//factory(User::class)->create();
		// Uso el helper factory
		create(User::class);

		// Vuelvo a testear, esta vez debería haber un usuario
		$this->assertEquals(1, User::count());
	}

	/**     
	 * Test de interfaz de login
	 * 
	 * @test
	 */
	public function login()
	{
		// Creo un nuevo usuario y le especifico un password para contar con el dato
		/*
		$user = factory(User::class)->create([
			'password' => Hash::make('passwdtest')
		]);
		*/
		// Uso el helper factory
		$user = create(User::class, ['password' => Hash::make('passwdtest')]);

		$this->visit('/login') 							// Especifico la URL sobre la que trabajo
			->type($user->email, 'email') 		// Ingreso dato de email
			->type('passwdtest', 'password') 	// Ingreso dato de password
			->press('Login') 									// Presiono botón de login
			->seePageIs('/home'); 						// Debería ir a home
	}

	/**     
	 * Test de interfaz de login con dato incorrecto
	 * 
	 * @test
	 */
	public function login_fails()
	{
		// Creo un nuevo usuario y le especifico un password para contar con el dato
		/*
		$user = factory(User::class)->create([
			'password' => Hash::make('passwdtest')
		]);
		*/
		// Uso el helper factory
		$user = create(User::class, ['password' => Hash::make('passwdtest')]);

		$this->visit('/login') 							// Especifico la URL sobre la que trabajo
			->type($user->email, 'email') 		// Ingreso dato de email
			->type('passwdtest2', 'password') // Ingreso dato de password
			->press('Login') 									// Presiono botón de login
			->seePageIs('/login') 						// Debería volver al login
			->see('These credentials do not match our records.'); // Debería ver el mensaje
	}

	/**     
	 * Test de interfaz de registro
	 * 
	 * @test
	 */
	public function register()
	{
		// Cantidad inicial de usuarios
		// Cómo tras cada test se refresca la base de datos, debería ser 0
		$this->assertEquals(0, User::count());

		$data = [
			'name' 			=> 'Test Name',
			'email' 		=> 'testemail@test.com',
			'password' 	=> '1234test'
		];

		$this->visit('/register') 							// Especifico la URL sobre la que trabajo
			// Ingreso de datos
			->type($data['name'], 'name')
			->type($data['email'], 'email')
			->type($data['password'], 'password')
			->type($data['password'], 'password_confirmation')
			->press('Register'); 									// Presiono botón de registro

		// En este caso puntual, luego del registro hay procesos de confirmación de email por fuera del sistema
		// Validamos unicamente que el registro haya sido insertado
		$this->assertEquals(1, User::count());

		// Otra comprobación puede ser que el usuario insertado en DB tenga el nombre ingresado
		$user = User::first();
		$this->assertEquals($data['name'], $user->name);
	}

	/**     
	 * Test de interfaz de creación de post
	 * 
	 * @test
	 */
	public function add_post(){
		$this->assertEquals(0, Post::count());

		// Creo un usuario
		$user = create(User::class);

		// Creo sesión
		$this->actingAs($user);

		// Test de acceso a sección (en este caso no es necesario ya que se repite en el siguiente assert)
		$this->visit('/posts/create')
			->assertResponseStatus(200);

		// Test de creación
		$data = [
			'title' => 'Post title',
			'content' => 'Loreom ipsum dolor sit amet'
		];
		$this->visit('/posts/create')
			->type($data['title'], 'title')
			->type($data['content'], 'content')
			->press('Enviar');

		$this->assertEquals(1, Post::count());
	}
}
