import { config } from '../../utils/config.js'
import { HTTP } from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    code: ""
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.createCode();
  },

  createCode() {
    var code;
    //首先默认code为空字符串
    code = '';
    //设置长度，这里看需求，我这里设置了4
    var codeLength = 4;
    //设置随机字符
    var random = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
    //循环codeLength 我设置的4就是循环4次
    for (var i = 0; i < codeLength; i++) {
      //设置随机数范围,这设置为0 ~ 36
      var index = Math.floor(Math.random() * 10);
      //字符串拼接 将每次随机的字符 进行拼接
      code += random[index];
    }
    //将拼接好的字符串赋值给展示的code
    this.setData({
      code: code
    })
  },

  /**
   * 登录
   */
  formSubmit(e) {
    var phone = e.detail.value.phone;
    if (phone == null || phone.length < 1) {
      wx.showToast({
        title: '请填写手机号',
        icon: "error"
      })
      return;
    }
    var password = e.detail.value.password;
    if (password == null || password.length < 1) {
      wx.showToast({
        title: '请填写密码',
        icon: "error"
      })
      return;
    }
    var code = e.detail.value.code;
    if (code == null || code.length < 1) {
      wx.showToast({
        title: '请填写验证码',
        icon: "error"
      })
      return;
    }
    var _this = this;
    if (code != _this.data.code) {
      wx.showToast({
        title: '验证码不正确',
        icon: "error"
      })
      return;
    }

    http.getRequest('api/vlogin/', {
      phone: phone,
      password: password
    }).then(res => {
      wx.showToast({
        title: '登录成功',
        duration: 1000
      })
      wx.setStorageSync('openid', res.data.data.openid);
      setTimeout(() => {
        wx.switchTab({
          url: '/pages/mine/index',
        })
      }, 1000);
    });

  }

})