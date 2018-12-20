<template>
  <div>

    <!-- button -->
    <el-row style="text-align: left; margin-top:30px;">
      <el-button type="primary" @click="dialogForm1Visible = true">新增</el-button>
      <el-button type="primary" @click="dialogForm2Visible = true">返利经验设置</el-button>
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
      <el-form ref="ruleForm1" :model="ruleForm1" :rules="rules1">

        <el-form-item :label-width="formLabel1Width" label="等级名称:" prop="lvName">
          <el-input v-model="ruleForm1.lvName" autocomplete="off" placeholder="请输入"/>
        </el-form-item>

        <el-form-item :label-width="formLabel1Width" label="一级返点:" prop="oneLvRebatePoint">
          <el-input v-model="ruleForm1.oneLvRebatePoint" autocomplete="off" placeholder="">
            <template slot="append"> % </template>
          </el-input>
        </el-form-item>

        <el-form-item :label-width="formLabel1Width" label="二级返点:" prop="twoLvRebatePoint">
          <el-input v-model="ruleForm1.twoLvRebatePoint" autocomplete="off" placeholder="">
            <template slot="append"> % </template>
          </el-input>
        </el-form-item>

        <el-form-item :label-width="formLabel1Width" label="三级返点" prop="threeLvRebatePoint">
          <el-input v-model="ruleForm1.threeLvRebatePoint" autocomplete="off" placeholder="">
            <template slot="append"> % </template>
          </el-input>
        </el-form-item>

        <el-form-item :label-width="formLabel1Width" label="所需经验:" prop="expNeed">
          <el-input v-model="ruleForm1.expNeed" autocomplete="off" placeholder=""/>
        </el-form-item>

      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogForm1Visible = false">取 消</el-button>
        <el-button type="primary" @click="dialogForm1Visible = false">保 存</el-button>
      </div>
    </el-dialog>

    <!-- dialog2 返利经验设置 -->
    <el-dialog :visible.sync="dialogForm2Visible" title="返利经验设置" center>
      <el-form ref="ruleForm2" :model="ruleForm2" :rules="rules2">

        <el-form-item :label-width="formLabel2Width" label="充值:" prop="moneyAdd">
          <el-input v-model="ruleForm2.moneyAdd" autocomplete="off" placeholder="请输入">
            <template slot="append"> 元 </template>
          </el-input>
        </el-form-item>

        <el-form-item :label-width="formLabel2Width" label="可获得:" prop="expAdd">
          <el-input v-model="ruleForm2.expAdd" autocomplete="off" placeholder="">
            <template slot="append"> 经验 </template>
          </el-input>
        </el-form-item>

      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogForm2Visible = false">取消</el-button>
        <el-button type="primary" @click="dialogForm2Visible = false">确认</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>

export default {
  data() {
    // dialog1 新增; 输入检验
    var checkRebatePoint = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('返点不能为空'))
      }
      setTimeout(() => {
        if (!Number.isInteger(value)) {
          // test
          console.log('type = ' + typeof (value))
          callback(new Error('返点设置必须为整数'))
        } else {
          if (value > 100 || value < 0) {
            callback(new Error('返点设置不合理'))
          } else {
            callback()
          }
        }
      }, 500)
    }
    var checkExp = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('经验设置不能为空'))
      }
      setTimeout(() => {
        if (!Number.isInteger(value)) {
          callback(new Error('经验设置必须为整数'))
        } else {
          callback()
        }
      }, 500)
    }

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
      formLabel1Width: '120px',

      // dialog2 返利经验设置
      dialogForm2Visible: false,
      formLabel2Width: '120px',

      // dialog1 输入验证
      ruleForm1: {
        lvName: '',
        oneLvRebatePoint: '',
        twoLvRebatePoint: '',
        threeLvRebatePoint: '',
        expNeed: ''
      },
      rules1: {
        lvName: [
          { required: true, message: '等级名称不能为空', trigger: 'blur' }
        ],
        oneLvRebatePoint: [
          { validator: checkRebatePoint, trigger: 'blur' }
        ],
        twoLvRebatePoint: [
          { validator: checkRebatePoint, trigger: 'blur' }
        ],
        threeLvRebatePoint: [
          { validator: checkRebatePoint, trigger: 'blur' }
        ],
        expNeed: [
          { validator: checkExp, trigger: 'blur' }
        ]
      },

      // dialog2 输入验证
      ruleForm2: {
        moneyAdd: '',
        expAdd: ''
      },
      rules2: {
        moneyAdd: [
          { required: true, message: '不能为空', trigger: 'blur' }
        ],
        expAdd: [
          { required: true, message: '不能为空', trigger: 'blur' }
        ]
      }
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
