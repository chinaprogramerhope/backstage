<template>
  <div>

    <el-row align="left" style="margin-top: 30px">
      <el-button type="primary" size="mini" @click="dialogFormAddVisible = true">+ 新增等级</el-button>
    </el-row>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'name', order:'descending'}"
      style="width: 100%; margin-bottom: 24px"
      stripe
    >
      <el-table-column prop="name" label="等级名称" align="center"/>
      <el-table-column prop="upPrice" label="晋升条件" align="center"/>
      <el-table-column prop="userNum" label="用户数" align="center"/>
      <el-table-column prop="operation" label="操作" align="center">
        <template slot-scope="scope">
          <div v-if="scope.row.name==='普通用户'">
            <el-tag size="mini">默认等级, 不可操作</el-tag>
          </div>
          <div v-else>
            <el-button size="mini" type="primary" @click="handleOpenEdit(scope.row.name)">编辑</el-button>
          </div>
        </template>
      </el-table-column>
    </el-table>

    <!-- 分页 -->
    <!-- <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      align="center"
      layout="total, sizes, prev, pager, next, jumper"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    /> -->

    <!-- dialog 新增等级 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="添加新的会员等级">
      <el-form :model="dialogFormAdd">

        <el-form-item
          :label-width="dialogLabelWidth"
          :rules="[
            { required: true, message: '请输入等级名称', trigger: 'blur' }
          ]"
          label="等级名称:"
          prop="name"
        >
          <el-input v-model="dialogFormAdd.name" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          :rules="[
            { required: true, message: '请输入金额', trigger: 'blur' }
          ]"
          label="晋升条件:"
          prop="upPrice"
        >
          <el-input v-model="dialogFormAdd.upPrice" autocomplete="off" placeholder="请输入金额">
            <theme slot="prepend">￥</theme>
          </el-input>
        </el-form-item>

        <el-form-item label="出款稽核模板:" required>
          <el-select v-model="dialogFormAdd.selectTemplate" placeholder="请选择" clearable>
            <el-option
              v-for="item in dialogFormAdd.optionsTemplate"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="备注:"
        >
          <el-input v-model="dialogFormAdd.note" :rows="2" type="textarea" autocomplete="off"/>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogFormAddVisible = false">取 消</el-button>
          <el-button type="primary" @click="handleAdd">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

    <!-- dialog 编辑 -->
    <el-dialog :visible.sync="dialogFormEditVisible" title="修改等级">
      <el-form :model="dialogFormEdit">

        <el-form-item
          :label-width="dialogLabelWidth"
          :rules="[
            { required: true, message: '请输入等级名称', trigger: 'blur' }
          ]"
          label="等级名称:"
          prop="name"
        >
          <el-input v-model="dialogFormEdit.name" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          :rules="[
            { required: true, message: '请输入金额', trigger: 'blur' }
          ]"
          label="晋升条件:"
          prop="upPrice"
        >
          <el-input v-model="dialogFormEdit.upPrice" autocomplete="off" placeholder="请输入金额">
            <theme slot="prepend">￥</theme>
          </el-input>
        </el-form-item>

        <el-form-item label="出款稽核模板:" required>
          <el-select v-model="dialogFormEdit.selectTemplate" placeholder="请选择" clearable>
            <el-option
              v-for="item in dialogFormEdit.optionsTemplate"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="备注:"
        >
          <el-input v-model="dialogFormEdit.note" :rows="2" type="textarea" autocomplete="off"/>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogFormEditVisible = false">取 消</el-button>
          <el-button type="danger" @click="handleDel()">删 除</el-button>
          <el-button type="primary" @click="handleEdit">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

  </div>
</template>

<script>
import { getLv } from '@/api/member'
import { addLv } from '@/api/member'
import { editLv } from '@/api/member'
import { delLv } from '@/api/member'

export default {
  data() {
    return {
      form1: {
        labelName: '',
        selectAutoPayOut: '是',
        sort: '',
        optionsAutoPayOut: [{
          label: '是',
          value: 'yes'
        }, {
          label: '否',
          value: 'no'
        }]
      },
      dialogLabelWidth: '120px',
      dialogFormAddVisible: false,

      dialogFormAdd: {
        name: '',
        upPrice: '',
        selectTemplate: '',
        optionsTemplate: [{
          label: '默认出款模板',
          value: 1
        }],
        note: ''
      },

      dialogFormEditVisible: false,
      dialogFormEdit: {
        name: '',
        upPrice: '',
        selectTemplate: '',
        optionsTemplate: [{
          label: '默认出款模板',
          value: 1
        }],
        note: ''
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 4
    }
  },

  created() {
    getLv().then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败: ' + response.msg,
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {

    // 获取
    handleGet() {
      getLv().then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // dialog 新增等级
    handleAdd() {
      this.dialogFormAddVisible = true

      const name = this.dialogFormAdd.name
      const upPrice = this.dialogFormAdd.upPrice
      const templateId = this.dialogFormAdd.selectTemplate
      const note = this.dialogFormAdd.note

      addLv(name, upPrice, templateId, note).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '新增等级成功',
            message: '',
            type: 'success'
          })

          this.dialogFormAddVisible = false

          this.handleGet()
        } else {
          this.$notify({
            title: '新增等级失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 打开编辑dialog
    handleOpenEdit(name) {
      this.dialogFormEditVisible = true
      var theRow = ''

      for (const v in this.tableData) {
        if (this.tableData[v].name === name) {
          theRow = this.tableData[v]
          break
        }
      }

      this.dialogFormEdit.name = theRow.name
      this.dialogFormEdit.upPrice = theRow.upPrice
      this.dialogFormEdit.selectTemplate = Number(theRow.templateId)
      this.dialogFormEdit.note = theRow.note
    },

    // dialog 编辑等级
    handleEdit() {
      const name = this.dialogFormEdit.name
      const upPrice = this.dialogFormEdit.upPrice
      const templateId = this.dialogFormEdit.selectTemplate
      const note = this.dialogFormEdit.note

      editLv(name, upPrice, templateId, note).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '编辑等级成功',
            message: '',
            type: 'success'
          })

          this.dialogFormEditVisible = false

          this.handleGet()
        } else {
          this.$notify({
            title: '编辑等级失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // dialog 删除等级
    handleDel() {
      const name = this.dialogFormEdit.name

      delLv(name).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '删除等级成功',
            message: '',
            type: 'success'
          })

          this.dialogFormEditVisible = false

          this.handleGet()
        } else {
          this.$notify({
            title: '删除等级失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // dialog
    submitRuleForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          alert('submit!')
        } else {
          this.$notify({
            title: '检验不通过, 请检查错误提示',
            message: '',
            type: 'warning'
          })
        }
      })
    }
  }
}
</script>
