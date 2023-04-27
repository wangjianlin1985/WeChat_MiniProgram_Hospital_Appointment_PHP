import { config } from '../../utils/config.js'
import { HTTP } from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {},

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var order_no = options.order_no;
    this.getOrder(order_no);
  },

  /**
   * 加载订单
   */
  getOrder(order_no) {
    var _this = this;
    http.getRequest('api/getOrder/' + order_no, {}).then(res => {
      _this.setData({
        order: res.data.data
      });
    });
  },

  /**
   * 订单支付
   */
  payOrder() {
    var _this = this;
    var pay_type = "";
    wx.showActionSheet({
      itemList: ["微信支付", "支付宝支付", "银行卡支付"],
      success(res) {
        //console.log(res.tapIndex)
        if (res.tapIndex == 0) {
          pay_type = "微信支付";
        }
        if (res.tapIndex == 1) {
          pay_type = "支付宝支付";
        }
        if (res.tapIndex == 2) {
          pay_type = "银行卡支付";
        }
        http.getRequest('api/payOrder/' + _this.data.order.order_no, {
          pay_type: pay_type,
          pay_money: _this.data.order.totals
        }).then(res => {
          wx.showToast({
            title: '支付成功',
            duration: 1000
          })
          setTimeout(() => {
            wx.redirectTo({
              url: '/pages/order/index',
            })
          }, 1000);
        });
      },
    })

  },


})