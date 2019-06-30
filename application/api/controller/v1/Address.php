<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/1
 * Time: 0:30
 */

namespace app\api\controller\v1;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use think\Request;

class Address
{
    public function createOrUpdateAddress() {
        $validate = new AddressNew();
        $validate->goCheck();
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user) {
            throw new UserException();
        }
        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if(!$userAddress) {
            // 添加操作
            $user->address()->save($dataArray);
        } else {
            // 更新操作
            $user->address->save($dataArray);
        }
        return json(new SuccessMessage(), 201);

    }
}