import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    sex:'boy',
    customer:{
      
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var openid = wx.getStorageSync('openid');
    if(openid){
      this.setData({
        openid:openid
      });
      this.getInfo();
    }else{
      wx.showToast({
        title: '请先登录',
        icon:"error"
      })
    }
  },

  /**
   * 获取个人信息
   */
  getInfo(){
    var _this = this;
    http.getRequest('api/getInfo/'+_this.data.openid,{}).then(res => {
      _this.setData({
        customer:res.data.data
      });
    });
  },

  /**
   * 性别按钮
   */
  sexRadioChange(e){
    var sex = e.detail.value;
    this.setData({
      sex:sex
    });
  },

  /**
   * 提交保存
   */
  formSubmit: function (e) {
    
    var username = e.detail.value.username;
    if (username == null || username.length < 1) {
      wx.showToast({
        title: '请填写昵称',
        icon:"error"
      })
      return;
    }
    var phone = e.detail.value.phone;
    if (phone == null || phone.length < 1) {
      wx.showToast({
        title: '请填写手机号',
        icon:"error"
      })
      return;
    }
    var password = e.detail.value.password;
    if (password == null || password.length < 1) {
      wx.showToast({
        title: '请填写密码',
        icon:"error"
      })
      return;
    }
    var idcard = e.detail.value.idcard;
    if (idcard == null || idcard.length < 1) {
      wx.showToast({
        title: '请填写身份证号',
        icon:"error"
      })
      return;
    }
    var address = e.detail.value.address;
    var _this = this;
    http.getRequest('api/updateInfo/'+_this.data.customer.openid,{
        username:username,
        phone:phone,
        password:password,
        idcard:idcard,
        sex:_this.data.sex,
        address:address,
    }).then(res => {
      wx.showToast({
        title: '保存成功',
        duration:1000
      })
      setTimeout(() => {
        wx.navigateBack();
      }, 1000);
    });
  },

  
})