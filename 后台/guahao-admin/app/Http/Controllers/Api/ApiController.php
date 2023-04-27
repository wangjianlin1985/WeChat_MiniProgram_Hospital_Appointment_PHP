<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Card;
use App\Models\City;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Forum;
use App\Models\Hospital;
use App\Models\Message;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Reply;
use App\Models\Video;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    //查询轮播图
    public function getBanner(Request $request)
    {
        $data = Banner::query()->orderByDesc('id')->get();
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ]);
    }

    //查询医生top10
    public function getDoctorTop10(Request $request)
    {
        $data = Doctor::query()
            ->orderByDesc('counts')
            ->offset(0)->limit(5)
            ->get();
        $data->map(function(Doctor $doctor){
            $city = City::find($doctor->city_id);
            if($city){
                $doctor->city = $city->name;
            }
            $hospital = Hospital::find($doctor->hospital_id);
            if($hospital){
                $doctor->hospital = $hospital->name;
            }
            $department = Department::find($doctor->department_id);
            if($department){
                $doctor->department = $department->name;
            }
        });
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ]);
    }

    //查询城市医院
    public function getCityHospital(Request $request)
    {
        $data = City::query()->get();
        $data->map(function(City $city){
            $hospitals = Hospital::query()->where('city_id','=',$city->id)->get();
            $city->hospitals = $hospitals;
        });
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ]);
    }

    //医院明细
    public function hospital(Request $request,$id)
    {
        $hospital = Hospital::find($id);
        $hospital->images = explode(",",$hospital->images);
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => $hospital
        ]);
    }

    //查询科室医生
    public function getDepartmentDoctor(Request $request)
    {
        $data = Department::query()->where('hospital_id','=',$request->get('hospital_id',0))->get();
        $data->map(function(Department $department){
            $doctors = Doctor::query()->where('department_id','=',$department->id)->get();
            $doctors->map(function(Doctor $doctor){
                $city = City::find($doctor->city_id);
                if($city){
                    $doctor->city = $city->name;
                }
                $hospital = Hospital::find($doctor->hospital_id);
                if($hospital){
                    $doctor->hospital = $hospital->name;
                }
                $department = Department::find($doctor->department_id);
                if($department){
                    $doctor->department = $department->name;
                }
            });
            $department->doctors = $doctors;
        });
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ]);
    }

    //查询文章
    public function getArticles(Request $request)
    {
        $page = $request->get('page',1);//默认第一页
        $limit = $request->get('limit',10);//默认每页10条
        $query = Article::query()->orderByDesc('id');
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'count' => $query->count(),
            'data' => $query->offset(($page-1)*$limit)->limit($limit)->get()
        ]);
    }

    //文章明细
    public function article(Request $request,$id)
    {
        $article = Article::query()->where('id','=',$id)->first();
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $article
        ];
    }

    //查询问卷
    public function getQuestionnaires(Request $request)
    {
        $page = $request->get('page',1);//默认第一页
        $limit = $request->get('limit',10);//默认每页10条
        $query = Questionnaire::query()->orderByDesc('counts');
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'count' => $query->count(),
            'data' => $query->offset(($page-1)*$limit)->limit($limit)->get()
        ]);
    }

    //问卷明细
    public function questionnaire(Request $request,$id)
    {
        $questionnaire = Questionnaire::query()->where('id','=',$id)->first();
        if($questionnaire){
            $questions = Question::query()
                ->where('questionnaire_id','=',$id)
                ->orderBy('no')
                ->get();
            $questionnaire->questions = $questions;
        }
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $questionnaire
        ];
    }

    //查询医生
    public function getDoctors(Request $request)
    {
        $page = $request->get('page',1);//默认第一页
        $limit = $request->get('limit',10);//默认每页10条
        $query = Doctor::query()->orderByDesc('counts');
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'count' => $query->count(),
            'data' => $query->offset(($page-1)*$limit)->limit($limit)->get()
        ]);
    }

    //医生明细
    public function doctor(Request $request,$id)
    {
        $doctor = Doctor::query()->where('id','=',$id)->first();
        if($doctor){
            date_default_timezone_set('Asia/Shanghai');//设置中国上海时区，要不获取时间有时差
            $dates = Plan::query()
                ->where('doctor_id','=',$id)
                ->where('date','>=',date('Y-m-d'))
                ->orderBy('date')
                ->distinct()
                ->get(['date']);
            $doctor->dates = $dates;
            $date = date('Y-m-d');
            if($dates->count()>0){
                $date = $dates[0]->date;
            }
            $plans = Plan::query()
                ->where('doctor_id','=',$id)
                ->where('date','=',$date)
                ->get();
            $doctor->plans = $plans;
        }
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $doctor
        ];
    }

    //查询医生出诊
    public function plan(Request $request,$id,$date)
    {
        $plans = Plan::query()
            ->where('doctor_id','=',$id)
            ->where('date','=',$date)
            ->get();
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $plans
        ];
    }

    //查询帖子
    public function getForums(Request $request)
    {
        $page = $request->get('page',1);//默认第一页
        $limit = $request->get('limit',10);//默认每页10条
        $query = Forum::query()->orderByDesc('counts');
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'count' => $query->count(),
            'data' => $query->offset(($page-1)*$limit)->limit($limit)->get()
        ]);
    }

    //帖子明细
    public function forum(Request $request,$id)
    {
        $forum = Forum::query()->where('id','=',$id)->first();
        if($forum){
            $customer = Customer::query()
                ->where('openid','=',$forum->openid)->first();
            if($customer){
                $forum->from_id = $customer->id;
                $forum->from = $customer->username;
            }
            $reply = Reply::query()
                ->where('forum_id','=',$forum->id)
                ->orderByDesc('id')
                ->get();
            $reply->map(function (Reply $reply){
                $from = Customer::query()->where('id','=',$reply->from_id)->first();
                if($from){
                    $reply->from = $from->username;
                }
                $to = Customer::query()->where('id','=',$reply->to_id)->first();
                if($to){
                    $reply->to = $to->username;
                }
            });
            $forum->reply=$reply;
        }
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $forum
        ];
    }

    //发布帖子
    public function saveForum(Request $request)
    {
        $openid = $request->get('openid');//openid
        $title= $request->get('title');//标题
        Forum::create([
            'openid'=>$openid,
            'title'=>$title,
            'counts'=>0,
            'status'=>1
        ]);
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => []
        ]);
    }

    //回复帖子
    public function replyForum(Request $request)
    {
        $forum_id = $request->get('forum_id',0);//帖子ID
        $from_id = $request->get('from_id',0);//留言人ID
        $to_id = $request->get('to_id',0);//回复人ID
        $content= $request->get('content');//内容
        $openid= $request->get('openid');//openid
        $customer = Customer::query()
            ->where('openid','=',$openid)->first();
        if($customer){
            $from_id = $customer->id;
        }
        Reply::create([
            'forum_id'=>$forum_id,
            'from_id'=>$from_id,
            'to_id'=>$to_id,
            'content'=>$content
        ]);
        $forum = Forum::query()->where('id','=',$forum_id)->first();
        $forum->counts += 1;
        $forum->save();
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => []
        ]);
    }

    //注册
    public function vreg(Request $request)
    {
        $username = $request->get('username');//用户名
        $password = $request->get('password');//密码
        $phone = $request->get('phone');//手机号
        $sex = $request->get('sex');//性别
        $idcard = $request->get('idcard');//身份证号
        $address = $request->get('address');//地址
        $avatar = $request->get('avatar');//头像
        $customer = Customer::query()->where('openid','=',$phone)->first();
        if($customer){
            return response()->json([
                'code' => 0,
                'msg' => '手机号已存在',
                'data' => []
            ]);
        }
        $flag = Customer::create([
            'username'=>$username,
            'password'=>$password,
            'phone'=>$phone,
            'sex'=>$sex,
            'idcard'=>$idcard,
            'address'=>$address,
            'avatar'=>$avatar,
            'openid'=>$phone
        ]);
        return response()->json([
            'code' => $flag?1:0,
            'msg' => $flag?'ok':'注册失败',
            'data' => []
        ]);
    }

    //登录
    public function vlogin(Request $request)
    {
        $phone = $request->get('phone');//手机号
        $password = $request->get('password');//密码
        //判断是否存在
        $data = Customer::query()
            ->where('phone','=',$phone)
            ->where('password','=',$password)
            ->first();
        if(!$data){
            return response()->json([
                'code' => 0,
                'msg' => '账号密码不匹配',
                'data' => []
            ]);
        }
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ]);
    }

    //查询个人信息
    public function getInfo(Request $request,$openid)
    {
        $data = Customer::query()->where('openid','=',$openid)->first();
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ]);
    }

    //修改个人信息
    public function updateInfo(Request $request,$openid)
    {
        $username = $request->get('username');//用户名
        $phone = $request->get('phone');//手机号
        $password = $request->get('password');//密码
        $sex = $request->get('sex');//性别
        $idcard = $request->get('idcard');//身份证号
        $address = $request->get('address');//地址
        $avatar = $request->get('avatar');//头像
        $customer = Customer::query()->where('openid','=',$openid)->first();
        $customer->username = $username;
        $customer->phone = $phone;
        $customer->password = $password;
        $customer->sex = $sex;
        $customer->idcard = $idcard;
        $customer->address = $address;
        $customer->avatar = $avatar;
        $customer->save();
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => []
        ]);
    }

    //提交问卷信息
    public function questionnaireSave(Request $request,$id)
    {
        $questions = $request->get('questions');//答题
        if($questions){
            $questionnaire = Questionnaire::query()->where('id','=',$id)->first();
            $questionnaire->counts = $questionnaire->counts + 1;
            $questionnaire->save();
            foreach (explode(';',$questions) as $question){
                $arr = explode(',',$question);
                $id = $arr[0];
                $option = $arr[1];
                $model = Question::query()->where('id','=',$id)->first();
                if($option=="A"){ $model->counta = $model->counta+1; }
                if($option=="B"){ $model->countb = $model->countb+1; }
                if($option=="C"){ $model->countc = $model->countc+1; }
                if($option=="D"){ $model->countd = $model->countd+1; }
                $model->save();
            }
        }
        return response()->json([
            'code' => 1,
            'msg' => 'ok',
            'data' => []
        ]);
    }

    //提交留言信息
    public function messageSave(Request $request,$id)
    {
        $openid = $request->get('openid');//openid
        $content = $request->get('content');//留言内容
        $customer = Customer::query()->where('openid','=',$openid)->first();
        $flag = false;
        if($customer){
            $flag = Message::create([
                'from_id'=>$customer->id,
                'to_id'=>$id,
                'receive'=>'doctor',
                'content'=>$content
            ]);
        }
        return response()->json([
            'code' => $flag?1:0,
            'msg' => $flag?'ok':'留言失败',
            'data' => []
        ]);
    }

    //提交预约
    public function saveOrder(Request $request)
    {
        $openid = $request->get('openid');
        $customer = Customer::query()->where('openid','=',$openid)->first();
        if(!$customer){
            return [
                'code' => 0,
                'msg' => '非法访问',
                'data' => []
            ];
        }
        if($customer->status==0){
            return [
                'code' => 0,
                'msg' => '已被拉黑，无法预约',
                'data' => []
            ];
        }
        $plan_id = $request->get('plan_id');//出诊ID
        $card = $request->get('card');//就诊人
        $message = $request->get('message');//留言
        $plan = Plan::query()->where('id','=',$plan_id)->first();
        if($plan->status==0){
            $order_no = date('YmdHis') . rand(10000, 99999);
            $doctor = Doctor::find($plan->doctor_id);
            $flag = Order::create([
                'openid'=>$openid,
                'plan_id'=>$plan_id,
                'hospital_id'=>$doctor->hospital_id,
                'department_id'=>$doctor->department_id,
                'doctor_id'=>$plan->doctor_id,
                'order_no'=>$order_no,
                'card'=>$card,
                'message'=>$message,
                'totals'=> $plan->price,
                'is_pay'=>0,
                'status'=>0,
            ]);
            if($flag){
                $plan->status = 1;
                $plan->save();
                $doctor = Doctor::query()->where('id','=',$plan->doctor_id)->first();
                $doctor->counts += 1;
                $doctor->save();
            }
            return [
                'code' => $flag?1:0,
                'msg' => $flag?'ok':'预约失败',
                'data' => $order_no
            ];
        }else{
            return [
                'code' => 0,
                'msg' => '该时间段已被预约',
                'data' => []
            ];
        }
    }

    //查询订单明细
    public function getOrder(Request $request,$order_no)
    {
        $order = Order::query()->where('order_no',$order_no)->first();
        if($order){
            $plan = Plan::query()->where('id',$order->plan_id)->first();
            if($plan){
                $order->date = $plan->date;
                $order->time = $plan->time;
                $doctor = Doctor::query()->where('id',$plan->doctor_id)->first();
                if($doctor){
                    $order->doctor = $doctor->name;
                    $order->doctor_id = $doctor->id;
                }
            }
        }
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $order
        ];
    }

    //订单支付
    public function payOrder(Request $request,$order_no)
    {
        $pay_type = $request->get('pay_type');//支付方式
        $pay_money = $request->get('pay_money');//支付金额
        $order = Order::query()->where('order_no',$order_no)->first();
        if($order){
            date_default_timezone_set('Asia/Shanghai');//设置中国上海时区，要不获取时间有时差
            $order->update([
                'is_pay'=>1,
                'status'=>1,
                'pay_type'=>$pay_type,
                'pay_money'=>$pay_money,
                'pay_time'=>date('Y-m-d H:i:s')
            ]);
        }
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => []
        ];
    }

    //退款订单
    public function tkOrder(Request $request,$order_no)
    {
        $order = Order::query()->where('order_no',$order_no)->first();
        if($order){
            $plan = Plan::query()->where('id',$order->plan_id)->first();
            $plan->status = 0;
            $plan->save();
            $order->status=2;
            $order->update();
            return [
                'code' => 1,
                'msg' => 'ok',
                'data' => []
            ];
        }else{
            return [
                'code' => 0,
                'msg' => '订单号不存在',
                'data' => []
            ];
        }
    }

    //取消支付
    public function cancelOrder(Request $request,$order_no)
    {
        $order = Order::query()->where('order_no',$order_no)->first();
        if($order){
            $plan = Plan::query()->where('id',$order->plan_id)->first();
            $plan->status = 0;
            $plan->save();
            Order::destroy($order->id);
            return [
                'code' => 1,
                'msg' => 'ok',
                'data' => []
            ];
        }else{
            return [
                'code' => 0,
                'msg' => '订单号不存在',
                'data' => []
            ];
        }
    }

    //查询个人订单
    public function findOrders(Request $request,$openid)
    {
        $is_pay = $request->get('is_pay');
        $data = Order::query()->orderByDesc('id')
            ->where('openid',$openid)
            ->when($is_pay,function($query) use ($is_pay){
                return $query->where('is_pay',$is_pay);
            })->get();
        $data->map(function(Order $order){
            $plan = Plan::query()->where('id',$order->plan_id)->first();
            if($plan){
                $order->date = $plan->date;
                $order->time = $plan->time;
                $doctor = Doctor::query()->where('id',$plan->doctor_id)->first();
                if($doctor){
                    $order->doctor = $doctor->name;
                    $order->doctor_id = $doctor->id;
                }
            }
        });
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ];
    }

    //查询我的留言
    public function findMessage(Request $request,$openid)
    {
        $customer = Customer::query()->where('openid','=',$openid)->first();
        $ctmId = $customer->id;
        $data = Message::query()
            ->orWhere(function ($query) use ($ctmId){
                $query->where('receive','=','doctor')->where('from_id','=',$ctmId);
            })
            ->orWhere(function ($query) use ($ctmId){
                $query->where('receive','=','customer')->where('to_id','=',$ctmId);
            })
            ->orderByDesc('id')
            ->get();
        $data->map(function(Message $message){
            if($message->receive=='doctor'){//客户留言
                $doctor = Doctor::where('id','=',$message->to_id)->first();
                if($doctor){
                    $message->to = $doctor->name;
                }
                $customer = Customer::where('id','=',$message->from_id)->first();
                if($customer){
                    $message->from = $customer->username;
                }
            }
            if($message->receive=='customer'){//医生回复
                $doctor = Doctor::where('id','=',$message->from_id)->first();
                if($doctor){
                    $message->from = $doctor->name;
                    $message->avatar = $doctor->avatar;
                }
                $customer = Customer::where('id','=',$message->to_id)->first();
                if($customer){
                    $message->to = $customer->username;
                }
            }
        });
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ];
    }

    //查询我的帖子
    public function findForum(Request $request,$openid)
    {
        $forum = Forum::query()->where('openid','=',$openid)->get();
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $forum
        ];
    }

    //删除我的帖子
    public function delForum(Request $request,$id)
    {
        $int = Forum::destroy($id);
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $int
        ];
    }

    //保存就诊卡
    public function cardSave(Request $request)
    {
        Card::create($request->all());
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => []
        ];
    }

    //就诊卡明细
    public function cardGet(Request $request)
    {
        $card = Card::find($request->get('id',0));
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $card
        ];
    }

    //修改就诊卡
    public function cardUpdate(Request $request)
    {
        Card::find($request->get('id'))->update($request->all());
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => []
        ];
    }

    //删除就诊卡
    public function cardDel(Request $request)
    {
        $int = Card::destroy($request->get('id'));
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $int
        ];
    }

    //我的就诊卡
    public function cardFind(Request $request)
    {
        $data = Card::query()->where('openid','=',$request->get('openid'))->get();
        $data->map(function(Card $card){
            $card->card = $card->name.' / '.$card->idcard;
        });
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ];
    }

    //统计
    public function tongji(Request $request)
    {
        $hospitals = Order::query()
            ->where('openid','=',$request->get('openid'))
            ->distinct('hospital_id')
            ->count();
        $departments = Order::query()
            ->where('openid','=',$request->get('openid'))
            ->distinct('department_id')
            ->count();
        $doctors = Order::query()
            ->where('openid','=',$request->get('openid'))
            ->distinct('doctor_id')
            ->count();
        $totals = Order::query()
            ->where('openid','=',$request->get('openid'))
            ->sum('totals');
        $data = [
            'yy'=>$hospitals,
            'ks'=>$departments,
            'ys'=>$doctors,
            'je'=>$totals,
        ];

        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ];
    }


}
