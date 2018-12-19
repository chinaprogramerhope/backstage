<template>
  <div>

    <!-- button -->
    <el-row style="text-align: left; margin-top:30px;">
      <el-button type="primary" @click="dialogForm1Visible">新增</el-button>
      <el-button type="primary" @click="dialogForm2Visible">返利经验设置</el-button>
    </el-row>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'date', order:'descending'}"
      stripe="true"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="lvName" label="等级名称" align="center"/>
      <el-table-column prop="oneLvRebatePoint" label="一级返点(%)" align="center"/>
      <el-table-column prop="twoLvRebatePoint" label="二级返点(%)" align="center"/>
      <el-table-column prop="threeLvRebatePoint" label="三级返点(%)" align="center"/>
      <el-table-column prop="expNeed" label="所需经验" align="center"/>
      <el-table-column prop="operation" label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="primary" @click="handleEdit()">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      layout="total, sizes, prev, pager, next, jumper"
      align="center"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />

    <!-- dialog1 新增 -->
    <el-dialog :visible.sync="dialogForm1Visible" title="新增返利等级" center>
      <el-form :model="form1">

        <el-form-item :label-width="formLabel1Width" label="选择体系:">
          <el-select v-model="form1.selectSystem" placeholder="请选择">
            <el-option
              v-for="item in form1.optionsSystem"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabel1Width" label="标题:">
          <el-input v-model="form1.title" autocomplete="off" placeholder="请输入"/>
        </el-form-item>

        <el-form-item :label-width="formLabel1Width" label="内容">
          <el-input v-model="form1.content" autocomplete="off" placeholder="请输入"/>
        </el-form-item>

      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogForm1Visible = false">取 消</el-button>
        <el-button type="primary" @click="dialogForm1Visible = false">保 存</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>

export default {
  data() {
    return {
      // tableData
      tableData: [{
        vipId: '2018-11-11 11:11:11',
        date: '2018-11-11 11:11:11',
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
      currentPage: 4,

      // dialog1 新增
      dialogForm1Visible: false,
      form1: {
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
      formLabel1Width: '120px',

      // dialog2 返利经验设置
      dialogForm2Visible: false,
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
      formLabel2Width: '120px'

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
