use Illuminate\Support\Facades\Hash;

public function login(Request $request)
{
    $fields = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string'
    ]);

    $email = $fields['email'];
    $password = $fields['password'];

    // 根據提供的 email 查詢使用者資料
    $user = DB::table('users')->where('email', $email)->first();

    if ($user && Hash::check($password, $user->password)) {
        // 使用者密碼驗證通過

        // 呼叫存儲過程
        $result = DB::select("CALL your_procedure_name(?, ?, @mytoken)", [$email, $password]);

        // 获取存储过程中设置的令牌值
        $tokenResult = DB::select("SELECT @mytoken AS token")[0]->token;

        $response = [
            'result' => $result[0]->result,
            'token' => $tokenResult
        ];
        return response()->json($response, 201);
    } else {
        // 使用者密碼驗證失敗
        $response = [
            'result' => '登入失敗',
            'token' => null
        ];
        return response()->json($response, 401);
    }
}
