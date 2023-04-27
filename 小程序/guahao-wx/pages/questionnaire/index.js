import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    questionnaireList:[
      //{id:1,title:'关于孩子心理健康的重要性调查?',counts:100}
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getQuestionnaires();
  },

  /**
   * 加载问卷
   */
  getQuestionnaires(){
    var _this = this;
    http.get('api/getQuestionnaires/',{}).then(res => {
      _this.setData({
        questionnaireList:res.data.data
      });
    });
  },

  
})