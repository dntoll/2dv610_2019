<?php

class PHPMock {
	private static $instancesCreated = 0;
	

	public static function Mock(string $sutClass) {
		$class_methods = get_class_methods($sutClass);
		$methodDeclarations = "";

		foreach ($class_methods as $methodName) {
			$refMethod = new ReflectionMethod($sutClass, $methodName);

			$paramList = "";
			$params = $refMethod->getParameters();
			foreach ($params as $key => $param) {
				if ($paramList != "")
					$paramList .= ", ";
				
				$paramList .= $param->getType() . " \$" .$param->getName();
			}

			$returnType = "";

			if ($refMethod->hasReturnType()) {
				$returnType	= ": " . $refMethod->getReturnType();
			}

			if ($methodName != "__construct") { //we dont add constructors since we dont want things to be initialized
				//The mock overrides all methods the class has but only calls __call on them
				$methodDeclarations .= "
				public function {$methodName}({$paramList}) $returnType { 
					\$arguments = func_get_args(); 
					return \$this->__callOnMock(\"$methodName\", \$arguments); 
				} \n";
			}

			
		}
		$instancesCreated = self::$instancesCreated;


		//Define the class as a mock class
		$classDeclaration = ("
		class MockInstance{$instancesCreated} extends $sutClass { 
			private \$mock;

			public function __construct() {

			}

			public function setMock(\$m) { 
				\$this->mock = \$m; 
			}

			public function __callOnMock(string \$name, array \$arguments) {
				return \$this->mock->_instanceCall(\$name, \$arguments);
			}

			public function whenCalled(string \$methodName, \$times =0) {
				return \$this->mock->whenCalled(\$methodName, \$times);
			}

			public function verify(string \$methodName) {
				return \$this->mock->verify(\$methodName);
			}

			public function getCallHistory(string \$methodName) : \MethodCallHistory {
				return \$this->mock->getCallHistory(\$methodName);
			}

			public function assertMethodNeverCalled(string \$methodName) {
				return \$this->mock->getCallHistory(\$methodName)->assertNeverCalled();	
			}

			public function assertMethodWasCalled(string \$methodName) {
				return \$this->mock->getCallHistory(\$methodName)->assertWasCalled();	
			}

			$methodDeclarations

		}; ");
		//echo("<pre>$classDeclaration</pre>");
		eval($classDeclaration);

		$mock = new PHPMock($sutClass);
		$instance = eval("return (new MockInstance{$instancesCreated}());" );
		$instance->setMock($mock);
		self::$instancesCreated++;

		return $instance;
	}


	private $whenCalled = array();
	private $numCallsToMethod = array();
	private $callHistory = array();
	private $methods = array();


	public function __construct(string $className) {
		$class_methods = get_class_methods($className);

		foreach ($class_methods as $methodName) {
			$this->methods[$methodName] = new MethodCallHistory();
			$this->whenCalled[$methodName] = array();
			$this->numCallsToMethod[$methodName] = 0;
		}
	}

	public function whenCalled(string $methodName, int $time) {

	//	var_dump("whenCalled $methodName $time");
		$call = new PHPMockCall($methodName);
		$this->whenCalled[$methodName][$time]  = $call;
		return $call;
	}

	
	public function _instanceCall(string $methodName , array $arguments) {

		if ($methodName === "getCallHistory")
			return call_user_func_array(array(__NAMESPACE__ .'\\' . __class__ , $methodName), $arguments);

		if (isset($this->methods[$methodName]) === false)
			throw new Exception("A call to method $methodName was done but no such method on Mocked class ");

		$call = new MethodCall($methodName, $arguments);
		//Capture order of calls
		$this->callHistory[] = $call;
		//Capture method statistics...
 		$this->methods[$methodName]->addCall($call);
 		$this->numCallsToMethod[$methodName]++;

		//Do the actual call
		$activeCallIndex = $this->numCallsToMethod[$methodName] - 1;
		if (isset($this->whenCalled[$methodName][$activeCallIndex]) ) {
			return $this->whenCalled[$methodName][$activeCallIndex]->call($arguments);
		} else {
			//try repeat the last registered whenCalled for that method...
			$lastRegisteredCallIndex = count($this->whenCalled[$methodName])-1;
			if (isset($this->whenCalled[$methodName][$lastRegisteredCallIndex]) ) {
				return $this->whenCalled[$methodName][$lastRegisteredCallIndex]->call($arguments);
			}

		}

//		var_dump($this->whenCalled[$methodName]);

		throw new Exception("No whenCalled() was on method [$methodName] [$activeCallIndex] times, but it still was called...");
		
	}

	public function getCallHistory(string $methodName) : MethodCallHistory {
		if (isset($this->methods[$methodName]))
			return $this->methods[$methodName];


		throw new \Exception("Method $methodName not found, when looking for it in Mock!");
	}
}

class MethodCall {
	public function __construct(string $methodName , array $arguments) {
		$this->methodName = $methodName;
		$this->arguments = $arguments;
	}
}

class MethodCallHistory {

	private $calls = array();

	public function addCall(MethodCall $instance) {
		$this->calls[] = $instance;
	}

	public function assertNeverCalled() {
		\TDD\Assert::assertTrue(count($this->calls) === 0);
	}

	public function assertWasCalled() {
		\TDD\Assert::assertTrue(count($this->calls) > 0 );	
	}

	public function assertHadParameter(...$params) {

		foreach ($params as $key => $value) {
			\TDD\Assert::assertTrue($this->calls[0]->arguments[$key] == $value);
		}
		
	}

}



class PHPMockCall {
	public function __construct($methodName) {
		$this->methodName = $methodName;
		$this->returnValue = false;
	}

	public function thenReturn($value) {
		$this->returnValue = $value;
	}

	public function call(array $arguments) {
		return $this->returnValue;
	}
}


/**
* Tests 
**/

class ToBeMocked {
	public function method() {
		throw new \Exception("This method should not be called!");
		return false;
	}

	public function methodWithParameter(int $e) {
		throw new \Exception("This method should not be called!");
	}

	public function methodWithParameters(string $s, int $e) {
		throw new \Exception("This method should not be called!");
	}
}

class MockTests extends \TDD\TestClass {
	public function getSystemUnderTestInstance() {
		$inst = \PHPMock::Mock("\ToBeMocked");
		return $inst;
	}

	public function shouldReturnWhatHasBeenSaid(\ToBeMocked $sut) {

		$value = true;
		$sut->whenCalled("method", 0)->thenReturn($value);
		$actual = $sut->method();

		\TDD\Assert::assertEquals($actual, $value);
	}

	public function shouldReturnWhatHasBeenSaid2(\ToBeMocked $sut) {

		$value = 15;
		$sut->whenCalled("method", 0)->thenReturn($value);
		$actual = $sut->method();

		\TDD\Assert::assertEquals($actual, $value);
	}

	public function shouldVerifyCallWasNOTMade(\ToBeMocked $sut) {
		
		$sut->getCallHistory("method");
		
		$sut->assertMethodNeverCalled("method");
	}

	public function shouldVerifyCallWasMade(\ToBeMocked $sut) {
		$sut->whenCalled("method", 0)->thenReturn(false);
		$sut->method();
		$sut->assertMethodWasCalled("method");
		$sut->assertMethodNeverCalled("methodWithParameter");
	}

	public function callHadParameter(\ToBeMocked $sut) {
		$sut->whenCalled("methodWithParameter", 0)->thenReturn(true);
		$sut->methodWithParameter(15);
		$sut->getCallHistory("methodWithParameter")->assertHadParameter(15);
		
	}

	public function callHadParameters(\ToBeMocked $sut) {
		$sut->whenCalled("methodWithParameters", 0)->thenReturn(true);
		$sut->methodWithParameters("donald", 15);
		$sut->getCallHistory("methodWithParameters")->assertHadParameter("donald", 15);
		
	}

	

}
