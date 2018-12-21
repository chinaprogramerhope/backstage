<template>
  <div>
    <!-- tabs 标签页 -->
    <el-tabs type="border-card" style="margin-top: 20px;">
      <el-tab-pane label="收件箱">

        <!-- 表单 -->
        <el-form :inline="true" :model="form1" style="margin-top: 20px;" align="left">
          <el-form-item>
            <el-button @click="dialogFormVisible1 = true">+ 发新消息</el-button>
          </el-form-item>

          <el-form-item label="标题:">
            <el-input v-model="form1.title"/>
          </el-form-item>

          <el-form-item label="收信时间:">
            <el-date-picker
              v-model="form1.dpValue1"
              type="datetimerange"
              range-separator="~"
              start-placeholder="开始时间"
              end-placeholder="结束时间"/>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
          </el-form-item>

        </el-form>

        <!-- table -->
        <el-table
          :data="tableData1"
          :default-sort="{prop: 'timeBegin', order:'descending'}"
          style="width: 100%; margin-bottom: 24px">
          <el-table-column prop="id" label="序号" align="center"/>
          <el-table-column prop="sender" label="发件人" align="center"/>
          <el-table-column prop="publishTime" label="发布时间" align="center"/>
          <el-table-column prop="title" label="标题" align="center"/>
          <el-table-column prop="alreadyRead" label="已读状态" align="center"/>
          <el-table-column prop="operation" label="操作" align="center">
            <template slot-scope="scope">
              <el-button type="primary" size="mini" @click="handleViewMessage()">查看消息</el-button>
            </template>
          </el-table-column>
        </el-table>

        <!-- 分页 -->
        <el-pagination
          :current-page="currentPage1"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          align="center"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />

        <!-- dialog 发送消息 -->
        <el-dialog :visible.sync="dialogFormVisible1" title="发送消息" center>
          <el-form :model="form2">

            <el-form-item :label-width="formLabelWidth1" label="选择体系:">
              <el-select v-model="form2.selectSystem" placeholder="请选择">
                <el-option
                  v-for="item in form2.optionsSystem"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item :label-width="formLabelWidth1" label="标题:">
              <el-input v-model="form2.title" autocomplete="off" placeholder="请输入"/>
            </el-form-item>

            <el-form-item :label-width="formLabelWidth1" label="内容">
              <el-input v-model="form2.content" autocomplete="off" placeholder="请输入"/>
            </el-form-item>

          </el-form>

          <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible1 = false">取 消</el-button>
            <el-button type="primary" @click="dialogFormVisible1 = false">保 存</el-button>
          </div>
        </el-dialog>

      </el-tab-pane>

      <el-tab-pane label="发件箱">
        <!-- 表单 -->
        <el-form :inline="true" :model="form3" style="margin-top: 20px;" align="left">
          <el-form-item>
            <el-button @click="dialogFormVisible2 = true">+ 发新消息</el-button>
          </el-form-item>

          <el-form-item label="标题">
            <el-input v-model="form3.title"/>
          </el-form-item>

          <el-form-item label="发信时间">
            <el-date-picker
              v-model="form3.dpValue1"
              type="datetimerange"
              range-separator="~"
              start-placeholder="开始时间"
              end-placeholder="结束时间"/>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
          </el-form-item>

        </el-form>

        <!-- table -->
        <el-table
          :data="tableData2"
          :default-sort="{prop: 'timeBegin', order:'descending'}"
          style="width: 100%; margin-bottom: 24px">
          <el-table-column prop="id" label="序号" align="center"/>
          <el-table-column prop="sender" label="收件人" align="center">
            <template slot-scope="scope">
              <el-button type="primary" size="mini" @click="handleViewRecipient()">查看收件人</el-button>
            </template>
          </el-table-column>
          <el-table-column prop="publishTime" label="发布时间" align="center"/>
          <el-table-column prop="title" label="标题" align="center"/>
          <el-table-column prop="alreadyRead" label="已读状态" align="center"/>
          <el-table-column prop="operation" label="操作" align="center">
            <template slot-scope="scope">
              <el-button type="primary" size="mini" @click="handleViewMessage()">查看消息</el-button>
            </template>
          </el-table-column>
        </el-table>

        <!-- 分页 -->
        <el-pagination
          :current-page="currentPage2"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          align="center"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />

        <!-- dialog 发送消息 -->
        <el-dialog :visible.sync="dialogFormVisible2" title="发送消息" center>
          <el-form :model="form4">

            <el-form-item :label-width="formLabelWidth2" label="选择体系:">
              <el-select v-model="form4.selectSystem" placeholder="请选择">
                <el-option
                  v-for="item in form4.optionsSystem"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item :label-width="formLabelWidth2" label="标题:">
              <el-input v-model="form4.title" autocomplete="off" placeholder="请输入"/>
            </el-form-item>

            <el-form-item :label-width="formLabelWidth2" label="内容">
              <el-input v-model="form4.content" autocomplete="off" placeholder="请输入"/>
            </el-form-item>

          </el-form>

          <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible2 = false">取 消</el-button>
            <el-button type="primary" @click="dialogFormVisible2 = false">保 存</el-button>
          </div>
        </el-dialog>
      </el-tab-pane>
    </el-tabs>

  </div>
</template>

<script>

export default {
  data() {
    return {
      /** 发件箱 */
      form1: {
        title: '',
        dpValue1: ''
      },

      // tableData
      tableData1: [{
        id: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        timeBegin: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
      }],

      // 分页
      currentPage1: 4,

      // dialog 发新消息
      dialogFormVisible1: false,
      form2: {
        title: '',
        content: '',

        optionsSystem: [{
          'label': '所有会员',
          'value': 'allVip'
        }, {
          'label': '会员等级',
          'value': 'vipLv'
        }, {
          'label': '单个会员',
          'value': 'singleVip'
        }, {
          'label': '多个会员',
          'value': 'multiVip'
        }]
      },

      formLabelWidth1: '120px',

      /** 收件箱 */
      form3: {
        title: '',
        dpValue1: ''
      },

      // tableData
      tableData2: [{
        id: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        timeBegin: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
      }],

      // 分页
      currentPage2: 4,

      // dialog 发新消息
      dialogFormVisible2: false,
      form4: {
        title: '',
        content: '',

        optionsSystem: [{
          'label': '所有会员',
          'value': 'allVip'
        }, {
          'label': '会员等级',
          'value': 'vipLv'
        }, {
          'label': '单个会员',
          'value': 'singleVip'
        }, {
          'label': '多个会员',
          'value': 'multiVip'
        }]
      },

      formLabelWidth2: '120px'
    }
  },
  methods: {
    obSubmit() {
      console.log('submit!')
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
